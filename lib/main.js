import './css/tailwind.css'
import './css/main.css'
import axios from "axios";


window.onload = function () {

    ShowCommentTip();

    ShowPreviewImage();

    HiddenPreviewImage();

    CommentFormSubmit();

    ShowCommentForm();

    LoadMore();

    ShowCommentEdit();

    PageScroll();
}
let offset = 10;
let pageSize = 10;

/**
 * 页面滚动加载
 */
function PageScroll() {
    window.onscroll = (event) => {
        const scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight || document.body.scrollHeight;
        const clientHeight = document.documentElement.clientHeight || document.body.clientHeight;

        if (scrollTop + clientHeight >= scrollHeight) {
            LoadMore()
        }
    }
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
 */
function ShowCommentForm() {
    let commentFormElements = document.querySelectorAll(".comment-btn");

    commentFormElements.forEach(element => {
        element.addEventListener("click", (event) => {

            let respondElement = getParent(event.target, 'comment-btn');
            let respondId = respondElement.getAttribute('data-respondId');
            let coid = respondElement.getAttribute("data-coid");
            let text = document.querySelector('.text-' + respondId);
            let hidden = true;
            if (text.getAttribute('data-coid') !== coid) {
                hidden = false;
            }

            // 如果有coid，则写入文本框
            if (coid) {
                let toName = respondElement.getAttribute('data-name');
                text.setAttribute('placeholder', '回复' + toName + '：');
                text.setAttribute('data-coid', coid);
                text.classList.add('coid-' + respondId);
            } else {
                text.setAttribute('placeholder', '评论');
                text.setAttribute('data-coid', '');
                // text.classList.remove('coid-' + respondId);
            }

            // 获取本地localStorage，如果本地有用户信息，则显示用户名称和展开按钮
            let mail = window.localStorage.getItem('archive-mail');

            if (mail) {
                let name = window.localStorage.getItem('archive-author');
                let userUrl = window.localStorage.getItem('archive-url');
                //只显示名称和展开按钮
                let hiddenName = document.querySelector('.hidden-name-' + respondId);
                hiddenName.innerText = name;
                let notExists = document.querySelector('.not-exists-' + respondId);
                notExists.classList.add('hidden');
                let exists = document.querySelector('.exists-' + respondId);
                exists.classList.remove('hidden');

                let nameElement = document.querySelector('.name-' + respondId);
                let mailElement = document.querySelector('.mail-' + respondId);
                let userUrlElement = document.querySelector('.user-url-' + respondId);

                nameElement.value = name;
                mailElement.value = mail;
                userUrlElement.value = userUrl;

            } else {
                //显示输入框
                let notExists = document.querySelector('.not-exists-' + respondId);
                notExists.classList.remove('hidden');
                let exists = document.querySelector('.exists-' + respondId);
                exists.classList.add('hidden');
            }

            let commentForm = document.querySelector(".comment-" + respondId);
            let classList = commentForm.classList;

            if (classList.contains('hidden')) {
                commentForm.classList.remove('hidden');
            } else {
                if (hidden) {
                    commentForm.classList.add('hidden');
                }
            }
        }, true);
    });
}

/**
 * 隐藏评论表单
 * @param className 名称
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
 * 显示评论用户信息编辑
 */
function ShowCommentEdit() {
    let commentEdits = document.querySelectorAll('.comment-edit');

    commentEdits.forEach((item) => {
        item.addEventListener('click', event => {
            let respondId = event.target.getAttribute('data-respondId');

            let hiddenName = document.querySelector('.hidden-name-' + respondId);
            hiddenName.innerText = name;
            let notExists = document.querySelector('.not-exists-' + respondId);
            notExists.classList.remove('hidden');
            let exists = document.querySelector('.exists-' + respondId);
            exists.classList.add('hidden');

        })
    })
}

/**
 * 显示点赞评论悬浮框
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
 */
function CommentFormSubmit() {
    let commentBtns = document.querySelectorAll('.comment-submit');

    commentBtns.forEach(item => {
        item.addEventListener('click', (event) => {
            let dataId = event.target.getAttribute('data-id');
            let xhx = document.querySelector('._' + dataId).value;

            let textElement = document.querySelector('.text-' + dataId);
            let cidElement = document.querySelector('.cid-' + dataId);
            let urlElement = document.querySelector('.url-' + dataId);
            let nameElement = document.querySelector('.name-' + dataId);
            let mailElement = document.querySelector('.mail-' + dataId);
            let userUrlElement = document.querySelector('.user-url-' + dataId);
            let coidElement = document.querySelector('.coid-' + dataId);

            let url = urlElement.getAttribute('data-action');
            let cid = cidElement.value;
            let text = textElement.value;
            let name = nameElement.value;
            let mail = mailElement.value;
            let userUrl = userUrlElement.value;
            let coid = '';
            if (coidElement) {
                coid = coidElement.getAttribute('data-coid');
            }

            let parameter = `cid=${cid}&themeAction=comment&text=${text}&_=${xhx}&author=${name}&url=${userUrl}&mail=${mail}&parent=${coid}`;

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
                        window.localStorage.setItem('archive-author', name);
                        window.localStorage.setItem('archive-mail', mail);
                        window.localStorage.setItem('archive-url', userUrl);
                    }
                })
                .catch(err => {
                    console.error('error')
                    console.log(err)
                })
        })
    })

}

/**
 * 上滑加载更多
 */
function LoadMore() {
    // 变更状态为加载中
    ChangeLoading(1);

    axios.get('index.php/archive/list?offset=3&limit=10')
        .then(data => {
            // 填充到文章列表后面。

            // 变更状态为加载完成
            ChangeLoading(2);
        })
        .catch(err => {
            console.log(err)

            // 变更状态为已加载
        })
}

/**
 * 变更加载状态
 * @param state 加载状态。1是加载中，2是加载完成
 */
function ChangeLoading(state){
    if(state === 1){

    }else if(state === 2){

    }
}