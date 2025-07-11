//$(function () {
//  new Sortable(document.getElementById("sortgrid"), {
//    animation: 150,
//    handle: ".td",
//    filter: ".new-plus",
//    ghostClass: "blue-background-class",
//  });
//
//  let thisFormAction = $($("form")[0]).attr("action");
//
//  $(".new-plus").click(function () {
//    $("#imageUpload").click();
//  });
//
//  let xsvg = $("#xsvg").val();
//
//  let currentImgLength = 0;
//  // 监听input type="file"的change事件
//  $("#imageUpload").change(async function (e) {
//    if (e.target.files.length == 0) {
//      alert(1111);
//      return;
//    }
//
//    if (e.target.files.length > 9 - currentImgLength) {
//      alert("最多只能上传9张图片，已上传" + currentImgLength + "张图片");
//      return;
//    }
//
//    for (let i = 0; i < e.target.files.length; i++) {
//      const file = e.target.files[i];
//      let fileUrl = await uploadFile(file);
//      if(fileUrl === false) return;
//      $("#sortgrid").append(`
//                <div class="bg-[#f0f0f0] w-full aspect-square td relative">
//                                <img src="${fileUrl[0]}"
//                                    class="w-full h-full object-cover td" />
//                                <div class="absolute right-3 top-3">
//                                    <img src="${xsvg}"
//                                        class="w-[18px] h-[18px] cursor-pointer bg-[#f0f0f0] rounded-full btn-img-remove" />
//                                </div>
//                            </div>
//                `);
//      currentImgLength++;
//    }
//
//    resetPictures();
//    $(".btn-img-remove").click(function () {
//      console.log(this);
//      $(this).closest(".td").remove();
//
//      currentImgLength--;
//      resetPictures();
//    });
//
//    $("#imageUpload").val("");
//  });
//
//  async function uploadFile(file) {
//    var formData = new FormData();
//
//    // 检查是否选择了文件
//    if (file) {
//      formData.append("image", file);
//      // 发送AJAX请求上传文件
//      return await $.ajax({
//        url: thisFormAction.replace(
//          "/action/contents-post-edit",
//          "/action/upload"
//        ), // 替换为你的上传接口URL
//        type: "POST",
//        data: formData,
//        processData: false, // 告诉jQuery不要去处理发送的数据
//        contentType: false, // 告诉jQuery不要去设置Content-Type请求头
//        success: async function (response) {
//          if (response === false) {
//            alert("上传图片失败，文件格式不被支持");
//            return false;
//          }
//          // 上传成功，显示弹窗
//          return response;
//        },
//        error: function (xhr, status, error) {
//          // 上传失败，显示错误信息（如果需要）
//          console.log("上传失败");
//          console.log(error);
//        },
//      });
//    }
//  }
//  function resetPictures() {
//    let picUrls = "";
//    $("img.td").each(function (index, item) {
//      picUrls += $(item).attr("src") + ",";
//    });
//
//    $("#friend_pictures").val(picUrls);
//  }
//  /**
//   * 点击emoji
//   */
//  function clickEmoji() {
//    $(".face-item").off("click");
//    $(".face-item").on("click", function (e) {
//      var input = $("#text");
//
//      var textToAppend = $(e.target).text(); // 要追加的文本
//      var currentVal = input.val();
//      input.val(currentVal + textToAppend);
//    });
//  }
//  clickEmoji();
//  function ClickEmojiBtn() {
//    $(".face-btn").off("click");
//    $(".face-btn").on("click", function () {
//      if ($(".face-container").is(":hidden")) {
//        $(".face-container").show();
//      } else {
//        $(".face-container").hide();
//      }
//    });
//  }
//  ClickEmojiBtn();
//
//  $(".ad-container").click(function () {
//    var adStatus = $(".ad-status").text();
//    if (adStatus === "是") {
//      $(".ad-status").text("否");
//      $("#isAdvertise").val("0");
//    } else {
//      $(".ad-status").text("是");
//      $("#isAdvertise").val("1");
//    }
//  });
//});
