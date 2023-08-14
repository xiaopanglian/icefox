import './css/tailwind.css'
import './css/main.css'
import axios from "axios";

window.onload = function () {

    ShowCommentTip();

    ShowPreviewImage();

    HiddenPreviewImage();

    CommentFormSubmit();

    ShowCommentForm();
}

/**
 * 获取指定class元素的下一级节点，找不到就从上级查找，递归方法
 * @param element
 * @param className
 * @returns {Element|*}
 */
function getParentNext(element, className) {
    if (element.classList.contains(className)) {
        return element.nextElementSibling;
    } else {
        return getParentNext(element.parentElement, className);
    }
}

/**
 * 获取指定class元素，找不到就从上级查找，递归方法
 * @param element
 * @param className
 * @returns {*}
 */
function getParent(element, className) {
    if (element.classList.contains(className)) {
        return element;
    } else {
        return getParent(element.parentElement, className);
    }
}

/**
 * 显示评论表单框
 * @constructor
 */
function ShowCommentForm() {
    let commentFormElements = document.querySelectorAll(".comment-btn");

    commentFormElements.forEach(element => {
        element.addEventListener("click", (event) => {

            let respondElement = getParent(event.target, 'comment-btn');
            let respondId = respondElement.getAttribute('data-respondId');

            let commentForm = document.querySelector(".comment-" + respondId);
            let classList = commentForm.classList;

            if (classList.contains('hidden')) {
                commentForm.classList.remove('hidden');
            } else {
                commentForm.classList.add('hidden');
            }
        }, true);
    });
}

/**
 * 隐藏评论表单
 * @param className
 * @constructor
 */
function HiddenCommentForm(className) {
    let commentForm = document.querySelector(className);
    let classList = commentForm.classList;

    if (classList.contains('hidden')) {
        commentForm.classList.remove('hidden');
    } else {
        commentForm.classList.add('hidden');
    }
}

/**
 * 显示点赞评论悬浮框
 * @constructor
 */
function ShowCommentTip() {
    let commentElements = document.querySelectorAll(".toggleCommentTip");

    commentElements.forEach(element => {
        element.addEventListener("click", (event) => {
            let element = getParentNext(event.target, 'commentPoint');
            HiddenAllCommentTip(element);
            let classList = element.classList;
            if (classList.contains('hidden')) {
                element.classList.remove('hidden')
            } else {
                element.classList.add('hidden')
            }

        }, true);
    })
}

/**
 * 隐藏所有点赞评论悬浮框
 * @param element
 * @constructor
 */
function HiddenAllCommentTip(element) {
    let commentTipElements = document.querySelectorAll('.commentTip');
    commentTipElements.forEach(item => {
            if (item !== element && !item.classList.contains('hidden')) {
                item.classList.add('hidden')
            }

        }
    )
}

/**
 * 显示预览大图
 * @constructor
 */
function ShowPreviewImage() {
    let imageElements = document.querySelectorAll('.preview-image');
    imageElements.forEach(element => {
        element.addEventListener('click', (event) => {

            document.getElementById('preview-image-tag').setAttribute('src', element.getAttribute('src'));

            let previewImage = document.querySelector("#preview-image");
            if (previewImage.classList.contains('hidden')) {
                previewImage.classList.remove('hidden');
            }
        })
    })
}

/**
 * 隐藏预览大图
 * @constructor
 */
function HiddenPreviewImage() {
    let previewImage = document.querySelector("#preview-image");

    previewImage.addEventListener('click', (event) => {
        let element = getParent(event.target, 'preview-div');

        if (!element.classList.contains('hidden')) {
            element.classList.add('hidden');
        }
    })
}

/**
 * 监听评论表单提交
 * @constructor
 */
function CommentFormSubmit() {
    let commentBtns = document.querySelectorAll('.comment-submit');

    commentBtns.forEach(item => {
        item.addEventListener('click', (event) => {
            let dataId = event.target.getAttribute('data-id');
            let xhx = document.querySelector('._' + dataId).value;

            let urlElement = document.querySelector('.url-' + dataId);
            let textElement = document.querySelector('.text-' + dataId);
            let cidElement = document.querySelector('.cid-' + dataId);
            let nameElement = document.querySelector('.name-' + dataId);
            let mailElement = document.querySelector('.mail-' + dataId);
            let userUrlElement = document.querySelector('.user-url-' + dataId);

            let url = urlElement.getAttribute('data-action');
            let cid = cidElement.value;
            let text = textElement.value;
            let name = nameElement.value;
            let mail = mailElement.value;
            let userUrl = userUrlElement.value;

            let parameter = `cid=${cid}&themeAction=comment&text=${text}&_=${xhx}&author=${name}&url=${userUrl}&mail=${mail}`;

            axios.post(url, parameter)
                .then(data => {
                    if (data.data.status === 0) {
                        alert(data.data.msg);
                    } else {
                        // 列表添加评论内容
                        let commentList = document.querySelector('.comment-list-' + dataId);
                        commentList.innerHTML += '<div>\n' +
                            '<a href="' + userUrl + '"><span class="text-[#576b95]">' + name + '</span></a><span>: ' + text + '</span>\n' +
                            '</div>';

                        HiddenCommentForm('.comment-' + dataId);

                        // 添加localStorage
                        window.localStorage.setItem('archive-' + cid + '-author', name);
                        window.localStorage.setItem('archive-' + cid + '-mail', mail);
                        window.localStorage.setItem('archive-' + cid + '-url', userUrl);
                    }
                })
                .catch(err => {
                    console.error('error')
                    console.log(err)
                })
        })
    })

}