let globalData = {
    webSiteHomeUrl: '',
    loadMorePage: 1,
    totalPage: 0
};

window.onload = async () => {
    // 网站接口请求地址前缀
    globalData.webSiteHomeUrl = document.querySelector('.webSiteHomeUrl').value;
    if (document.querySelector('._currentPage')) {
        globalData.loadMorePage = parseInt(document.querySelector('._currentPage').value);
    }
    if (document.querySelector('._totalPage')) {
        globalData.totalPage = parseInt(document.querySelector('._totalPage').value);
    }

    loadQW();
    clickQW();
    clickSS();

    // 点击打开互动悬浮框
    clickHudong();

    // 点击评论
    clickComment();

    // 点击点赞
    clickLike();

    // 点击emoji
    clickEmoji();

    // 大图预览
    let previewImages = document.querySelectorAll('.preview-image');
    previewImages.forEach((element) => {
        imagePreviewAddEventListener(element);
    });

    // 下拉加载更多
    // https://github.com/fa-ge/Scrollload/blob/master/README.md
    new Scrollload({
        container: document.querySelector('.main-container'),
        content: document.querySelector('.article-container'),
        // 底部加载中的html
        loadingHtml: generateHtml('-- 加载中 --'),
        // 底部没有更多数据的html
        noMoreDataHtml: generateHtml('-- 没有更多数据了 --'),
        // 底部出现异常的html
        exceptionHtml: generateHtml('-- 出现异常 --'),
        loadMore: async function (sl) {

            if (globalData.loadMorePage < globalData.totalPage) {
                globalData.loadMorePage += 1;

                await pjax(globalData.loadMorePage, '.article-container');
            }

            if (globalData.loadMorePage >= globalData.totalPage) {
                // 没有数据的时候需要调用noMoreData
                sl.noMoreData();
                return;
            }

            sl.unLock();
        },
        pullRefresh: function (sl) {
            sl.refreshComplete();
        }
    });

    $(".go-back").on('click',function(){
        window.history.back();
    });
};

/**
 * 加载文章是否需要全文按钮
 */
function loadQW() {
    $.each($(".article-content"), function (index, element) {
        if (element.scrollHeight > element.offsetHeight) {
            let cid = $(element).data('cid');

            //添加全文按钮
            $(".qw-" + cid).removeClass('hidden');
        }
    })
}

// 点击全文按钮
function clickQW() {
    $(".qw").off('click');
    $(".qw").on('click', function (e) {
        $(e.target).addClass('hidden');

        let cid = $(e.target).data('cid');

        $(".content-" + cid).removeClass("line-clamp-4");
        $(".ss-" + cid).removeClass('hidden');
    });
}

// 点击收缩按钮
function clickSS() {
    $(".ss").off('click');
    $(".ss").on('click', function (e) {
        $(e.target).addClass('hidden');

        let cid = $(e.target).data('cid');

        $(".content-" + cid).addClass("line-clamp-4");
        $(".qw-" + cid).removeClass('hidden');
    });
}

// 全局窗口点击事件
let hudongBox = document.querySelector('.hudong');
window.addEventListener('click', (event) => {
    // 判断点击的是否是悬浮框，不是就隐藏
    if (event.target.classList.contains('hudong')) {
        return;
    }
    if (event.target.classList.contains('comment-to')) {
        return;
    }
    if (event.target.classList.contains('face')) {
        return;
    }
    if (event.target.classList.contains('face-item')) {
        return;
    }
    if (event.target.classList.contains('face-container')) {
        return;
    }
    if ($(event.target).prop('tagName') === 'INPUT') {
        return;
    }
    if ($(event.target).prop('tagName') === 'BUTTON') {
        return;
    }
    // 隐藏所有互动悬浮框
    hiddenHudongModal();
    removeAllCommentForm();
});

/**
 * 点击emoji
 */
function clickEmoji() {
    $(".face-item").off('click');
    $(".face-item").on('click', function (e) {
        let cid = $(e.target).data('cid');
        var input = $('input[data-cid=' + cid + '].input-text');

        var textToAppend = $(e.target).text(); // 要追加的文本  
        var currentVal = input.val();
        input.val(currentVal + textToAppend);
    });
}

/**
 * 点击emoji表情显示/隐藏emoji
 */
function clickEmojiFace() {
    $(".face").off('click');
    $(".face").on('click', function (e) {
        let cid = $(e.target).data('cid');
        var faceContainer = $('.face-container[data-cid=' + cid + ']');

        if ($(faceContainer).hasClass('hidden')) {
            $(faceContainer).removeClass('hidden');
        } else {
            $(faceContainer).addClass('hidden');
        }
    });
}

/**
 * 点击互动
 */
function clickHudong() {
    $(".hudong").off('click');
    $(".hudong").on('click', function (e) {
        let hudongElement = e.target;

        hiddenHudongModal();
        removeAllCommentForm();

        let modal = $(hudongElement).next();
        modal.removeClass('hidden');
    });
}
/**
 * 点击评论
 */
function clickComment() {
    $(".comment-to").off('click');
    $(".comment-to").on('click', function (e) {
        removeAllCommentForm();

        let cid = $(e.target).data('cid');
        let coid = $(e.target).data('coid');
        let name = $(e.target).data('name');

        if (coid == undefined) {
            // 如果没有coid，那么就在最下方显示评论框
            document.querySelector('.comment-ul-cid-' + cid).insertAdjacentHTML('beforeend', getCommentFormHtml(cid));
        } else {
            //有coid，在对应评论处显示评论框
            document.querySelector('.comment-li-coid-' + coid).insertAdjacentHTML('afterend', getCommentFormHtml(cid, coid, name));
        }

        clickEmoji();
        clickEmojiFace();

        // 点击评论回复按钮
        $(".btn-comment").off('click');
        $(".btn-comment").on('click', function (e) {
            let cid = $(e.target).data('cid');
            let coid = $(e.target).data('coid');

            let requiredMail = $("#commentsRequireMail").val();
            let requiredURL = $("#commentsRequireURL").val();

            let author = document.querySelector('.input-author').value;
            let url = document.querySelector('.input-url').value;
            let mail = document.querySelector('.input-mail').value;
            let text = document.querySelector('.input-text').value;
            let param = {
                cid: cid,
                parent: coid,
                author: author,
                mail: mail,
                url: url,
                text: text,
            };
            if (param.author === '') {
                alert('昵称不能为空');
                return;
            }
            if (requiredMail == 1 && param.mail === '') {
                alert('邮件不能为空');
                return;
            }
            if (requiredURL == 1 && param.url === '') {
                alert('网址不能为空');
                return;
            }
            if (param.text === '') {
                alert('评论内容不能为空');
                return;
            }

            // 记录信息到localStorage
            window.localStorage.setItem('author', author);
            window.localStorage.setItem('mail', mail);
            window.localStorage.setItem('url', url);

            axios.post(globalData.webSiteHomeUrl + '/api/comment', param,
                { headers: { 'content-type': 'application/x-www-form-urlencoded' } })
                .then(function (response) {
                    if (response.data.status == 1) {
                        removeAllCommentForm();

                        let waiting = '';
                        // 把评论显示在对应位置
                        if (response.data.comment.status == 'waiting') {
                            // 显示待审核
                            waiting = '<span class="comment-waiting">待审核</span>';
                        }

                        if (param.parent > 0) {
                            //有coid，在对应评论处显示评论框
                            document.querySelector('.comment-li-coid-' + param.parent).insertAdjacentHTML('afterend', `
                                <li class="pos-rlt comment-li-coid-${response.data.comment.coid}">
                        <div class="comment-body">
                            <span class="text-[14px] text-color-link">
                                <a href="${response.data.comment.url}" target="_blank" class="cursor-pointer text-color-link no-underline">${response.data.comment.author}</a>
                            </span>
                            <span class="text-[14px]">回复</span>
                            <span class="text-[14px] text-color-link">${name}</span>
                            <span data-separator=":" class="before:content-[attr(data-separator)] text-[14px] cursor-help comment-to" data-coid="${response.data.comment.coid}" data-cid="${response.data.comment.cid}" data-name="${response.data.comment.author}">${param.text}</span>
                            ${waiting}
                        </div>
                    </li>`);

                        } else {
                            // 如果没有coid，那么就在最下方显示评论框
                            document.querySelector('.comment-ul-cid-' + param.cid).insertAdjacentHTML('beforeend', `
                                <li class="pos-rlt comment-li-coid-${response.data.comment.coid}">
                    <div class="comment-body">
                        <span class="text-[14px] text-color-link">
                            <a href="${response.data.comment.url}" target="_blank" class="cursor-pointer text-color-link no-underline">${response.data.comment.author}</a>
                        </span>
                        <span data-separator=":" class="before:content-[attr(data-separator)] text-[14px] cursor-help comment-to" data-coid="${response.data.comment.coid}" data-cid="${response.data.comment.cid}" data-name="${response.data.comment.author}">${param.text}</span>
                        ${waiting}
                    </div>
                </li>
                                `);
                        }
                    } else {
                        // 评论异常，弹出进行提醒
                        alert(response.data.msg);
                    }

                })
                .catch(function (error) {
                    alert('系统异常，请稍候重试')
                });
        });

    });
}

/**
 * 点击点赞
 */
function clickLike() {
    $(".like-to").off('click');
    $(".like-to").on('click', function (e) {
        let cid = $(e.target).data('cid');
        let agree = $(e.target).data('agree');

        if (cid == 0) {
            return alert('点赞失败');
        }

        let param = { cid: cid, agree: agree };
        axios.post(globalData.webSiteHomeUrl + '/api/like', param, { headers: { 'content-type': 'application/x-www-form-urlencoded' } })
            .then(function (response) {
                if (response.data.status == 1) {
                    // 点赞成功
                    if ($(".like-agree-" + cid).hasClass('hidden')) {
                        $(".like-agree-" + cid).removeClass('hidden');
                        $(".like-agree-" + cid).addClass('flex');
                    }

                    // agree=1是点赞，0是取消点赞
                    if (agree === 1) {
                        // 显示取消
                        $(".like-to-cancel-" + cid).removeClass('hidden');
                        $(".like-to-cancel-" + cid).addClass('flex');

                        $(".like-to-show-" + cid).addClass('hidden');
                        $(".like-to-show-" + cid).removeClass('flex');
                    } else {
                        $(".like-to-cancel-" + cid).addClass('hidden');
                        $(".like-to-cancel-" + cid).removeClass('flex');

                        $(".like-to-show-" + cid).removeClass('hidden');
                        $(".like-to-show-" + cid).addClass('flex');

                        if (response.data.agree == 0) {
                            if (!$(".like-agree-" + cid).hasClass('hidden')) {
                                $(".like-agree-" + cid).addClass('hidden');
                                $(".like-agree-" + cid).removeClass('flex');
                            }
                        }
                    }

                    $(".fk-cid-" + cid).text(response.data.agree);
                }
            })
            .catch(function (error) {

            });
    });

}
/**
 * 隐藏所有互动悬浮框
 */
function hiddenHudongModal() {
    let hudongModalList = document.querySelectorAll('.hudong-modal');

    hudongModalList.forEach(item => {
        if (!item.classList.contains('hidden')) {
            item.classList.add('hidden');
        }
    });
}

/**
 * 获取评论框Html
 */
function getCommentFormHtml(cid, coid, name) {

    let author = window.localStorage.getItem('author');
    let mail = window.localStorage.getItem('mail');
    let url = window.localStorage.getItem('url');
    if (author == null) {
        author = '';
    }
    if (mail == null) {
        mail = '';
    }
    if (url == null) {
        url = '';
    }

    let placeholder = '回复内容';
    if (coid) {
        placeholder = '回复@' + name;
    }
    return `
    <li class="comment-form" data-cid="${cid}" data-coid="${coid}">
    <div class="bg-white dark:bg-[#262626] p-2 rounded-sm border-1 border-solid border-[#07c160]">
        <div class="grid grid-cols-3 gap-2">
            <input placeholder="昵称" class="border-0 outline-none bg-color-primary dark:bg-[#323232] p-1 rounded-sm input-author dark:text-[#cccccc]" data-cid="${cid}" data-coid="${coid}" value="${author}" />
            <input placeholder="网址" class="border-0 outline-none bg-color-primary dark:bg-[#323232] p-1 rounded-sm input-url dark:text-[#cccccc]" data-cid="${cid}" data-coid="${coid}" value="${url}" />
            <input placeholder="邮箱" class="border-0 outline-none bg-color-primary dark:bg-[#323232] p-1 rounded-sm input-mail dark:text-[#cccccc]" data-cid="${cid}" data-coid="${coid}" value="${mail}" />
        </div>
        <div class="mt-2">
            <input placeholder="${placeholder}" class="border-0 outline-none w-full rounded-sm p-1 input-text dark:bg-[#323232] dark:text-[#cccccc]" data-cid="${cid}" data-coid="${coid}" />
        </div>
        <div class="face-container hidden" data-cid="${cid}" data-coid="${coid}">
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😀</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😄</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😁</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😆</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😅</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😂</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤣</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😊</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😇</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🙂</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🙃</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😉</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😌</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😍</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🥰</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😘</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😗</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😙</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😚</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😋</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😛</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😝</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😜</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤪</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤨</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🧐</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤓</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😎</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤩</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🥳</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😏</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😒</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😞</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😔</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😟</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😕</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🙁</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">☹️</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😣</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😖</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😫</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😩</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🥺</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😢</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😭</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😤</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😠</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😡</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤬</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤯</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😳</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🥵</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🥶</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😱</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😨</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😰</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😥</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😓</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤗</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤔</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤭</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤫</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤥</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😶</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😐</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😑</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😬</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🙄</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😯</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😦</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😧</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😮</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😲</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🥱</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😴</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤤</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😪</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😵</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤐</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🥴</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤢</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤮</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤧</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">😷</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤒</span>
<span class="cursor-pointer face-item" data-cid="${cid}" data-coid="${coid}">🤕</span>
        </div>
        <div class="flex justify-end mt-2">
            <div class="face mr-2 cursor-pointer" data-cid="${cid}" data-coid="${coid}"></div>
            <button class="btn-comment bg-[#07c160] border-0 outline-none text-white cursor-pointer rounded-sm" data-cid="${cid}" data-coid="${coid}">回复</button>
        </div>
    </div>
</li>
    `;
}

/**
 * 移除其他评论框
 */
function removeAllCommentForm() {
    $(".comment-form").remove();
}

/**
 * 下拉加载底部显示文字生成html
 */
function generateHtml(html) {
    return html;
}

let imgElementArray = [];
let gallery;
/**
 * 大图预览。给大图元素绑定点击事件
 */
function imagePreviewAddEventListener(element) {
    imgElementArray.push(element);
    element.addEventListener('click', event => preview(event));
}

function preview(event) {
    let cid = event.target.attributes['data-cid'].value;

    if (gallery)
        gallery.destroy();

    gallery = new Viewer(document.getElementById('preview-' + cid), {
        focus: false,
        navbar: false,
        rotatable: false,
        scalable: false,
        slideOnTouch: false,
        title: false,
        toggleOnDblclick: false,
        tooltip: false,
    });

    gallery.show();

}

/**
 * 移除所有图片大图预览绑定事件
 */
function imagePreviewRemoveAllEventListener() {
    imgElementArray.forEach(e => {
        e.removeEventListener('click', event => preview(event));
    })

    imgElementArray = [];
}

/**
 * pjax请求，追加列表分页
 */
async function pjax(pageIndex, container) {
    let url = globalData.webSiteHomeUrl + '/page/' + pageIndex;
    await axios.get(url).then(async (e) => {
        // 获取新内容
        var domParser = new DOMParser();
        var newContent = domParser.parseFromString(e.data, 'text/html').querySelector(container);

        // 追加到当前列表的最下方
        imagePreviewRemoveAllEventListener();

        var articleContainer = document.querySelector(container);
        articleContainer.appendChild(newContent);

        // 重新绑定图片预览
        let previewImages = document.querySelectorAll('.preview-image');
        previewImages.forEach((element) => {
            imagePreviewAddEventListener(element);
        });
        // 重新绑定互动
        clickHudong();
        // 重新绑定评论
        clickComment();
        // 重新绑定点赞
        clickLike();

        loadQW();
        clickQW();
        clickSS();
    }).catch(e => {

    });
}

/**
 * 回到顶部
 */
var timeOut;
function scrollToTop() {
    if (document.body.scrollTop != 0 || document.documentElement.scrollTop != 0) {
        window.scrollBy(0, -50);
        timeOut = setTimeout('scrollToTop()', 10);
    }
    else clearTimeout(timeOut);
}