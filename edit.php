<?php
/**
 * 前端发布文章
 *
 * @package custom
 */
?>


<?php $this->need('/components/header.php'); ?>


<div class="bg-white dark:bg-[#323232] dark:text-[#cccccc] mx-auto main-container" :class="{'dark':darkMode}">
    <div class="h-14 bg-[#f0f0f0] flex flex-row justify-between items-center">
        <div>
            <img src="<?php $this->options->themeUrl('assets/svgs/btn-left.svg'); ?>" class="w-[24px] h-[24px]" />
        </div>
        <div>
            <button
                class="btn-comment bg-[#07c160] border-0 outline-none text-white cursor-pointer rounded text-sm px-5 py-2">发表</button>
        </div>
    </div>
    <div class="mt-2 px-5">
        <textarea placeholder="这一刻的想法" class="w-full h-20 outline-none p-2 border-none resize-none"></textarea>
    </div>
    <div class="mt-2 px-5">
        <span class="bg-[#f0f0f0] p-3 rounded inline-flex cursor-pointer">
            <img src="<?php $this->options->themeUrl('assets/svgs/smile.svg'); ?>"
                class="w-[18px] h-[18px] cursor-pointer" />
        </span>
    </div>
    <div class="px-5">
        <hr />
        <div class="grid grid-cols-3 gap-5">
            <div class="bg-[#f0f0f0] w-full aspect-square">
                <img src="https://tse1-mm.cn.bing.net/th/id/OIP-C.3ch3ETbSknC0tCGqriUKbQHaEK?rs=1&pid=ImgDetMain"
                    class="w-full h-full object-cover" />
            </div>
            <div class="bg-[#f0f0f0] w-full aspect-square">
                <img src="https://ts1.cn.mm.bing.net/th/id/R-C.ff7c64a463994bdf6baba431c1dbcc39?rik=FAE80%2f8m38bECg&riu=http%3a%2f%2fpic.kuaizhan.com%2fg3%2f3a%2f45%2f0b48-a822-474e-b14e-4cd1c30b3afc27%2fimageView%2fv1%2fthumbnail%2f640x0&ehk=oAXgSutiOA8yuRempxJY1pzqtzrUeNp%2fY4wKnfpit%2f8%3d&risl=&pid=ImgRaw&r=0"
                    class="w-full h-full object-cover" />
            </div>
            <div class="bg-[#f0f0f0] w-full aspect-square">
                <img src="https://ts1.cn.mm.bing.net/th/id/R-C.0caead272694e4f779f2f095ef1e3214?rik=9UXR5rHGtBHRcg&riu=http%3a%2f%2fn.sinaimg.cn%2fsinacn20107%2f685%2fw599h886%2f20190427%2fc91a-hvvuiyp2168363.jpg&ehk=KBe4MAqgsaDNeLSAwRKzn2k8u9ZeVdXnRgVc0KkF2Xc%3d&risl=&pid=ImgRaw&r=0"
                    class="w-full h-full object-cover" />
            </div>
            <div class="bg-[#f0f0f0] w-full aspect-square flex justify-center items-center">
                <img src="<?php $this->options->themeUrl('assets/svgs/plus.svg'); ?>"
                    class="w-[18px] h-[18px] cursor-pointer" />
            </div>
        </div>
    </div>
    <div class="px-5">
        <hr />
        <div class="flex flex-row items-center gap-3 py-2">
            <img src="<?php $this->options->themeUrl('assets/svgs/position.svg'); ?>" class="w-[18px] h-[18px]" />
            <input placeholder="所在位置" class="border-0 w-full outline-none" />
        </div>
    </div>
    <div class="px-5 pb-5">
        <hr />
        <div class="flex flex-row justify-between py-2">
            <div class="flex gap-3">
                <div class="text-xs border border-solid border-[#999] px-1">AD</div>
                <div class="">是否广告</div>
            </div>
            <div>
                是
            </div>
        </div>
    </div>
</div><!-- end #main-->