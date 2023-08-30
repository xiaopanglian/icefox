let Time = {
    //获取当前时间戳
    getUnix: function () {
        let date = new Date();
        return date.getTime();
    },
    //获取当前0点0分0秒0毫秒的时间戳
    getToDayUnix: function () {
        let date = new Date();
        date.setHours(0);
        date.setMinutes(0);
        date.setSeconds(0);
        date.setMilliseconds(0);
        return date.getTime();
    },
    //获取今年1月1日0点0分0秒的时间戳
    getYearUnix: function () {
        let date = new Date();
        date.setMonth(0);
        date.setDate(0);
        date.setHours(0);
        date.setMinutes(0);
        date.setSeconds(0);
        return date.getTime();
    },
    //获取标准年月日
    getLastDate: function (time) {
        let date = new Date(time);
        let month =
            date.getMonth() + 1 < 10
                ? "0" + (date.getMonth() + 1)
                : date.getMonth() + 1; //月从0开始，需要+1
        let day = date.getDate() < 10 ? "0" + date.getDate() : date.getDate(); //格式 01-09
        return date.getFullYear() + "-" + month + "-" + day;
    },
    //转换时间
    getFormatTime: function (timestamp) {
        let now = this.getUnix(); //当前时间戳 毫秒级
        let time = timestamp * 1000; //转为毫秒，如果是毫秒可以去除转换
        //由于 timestamp 是秒，所以需要乘以1000
        let timer = (now - time) / 1000; //转换为秒级时间戳

        let tip = "";
        if (timer <= 0) {
            tip = "刚刚";
        } else if (Math.floor(timer / 60) <= 0) {
            tip = "刚刚";
        } else if (timer < 3600) {
            tip = Math.floor(timer / 60) + "分钟前";
        } else if (timer >= 3600 && timer < 86400) {
            tip = Math.floor(timer / 3600) + "小时前";
        } else if (timer >= 86400 && timer / 86400 <= 31) {
            tip = Math.floor(timer / 86400) + "天前";
        } else {
            //要注意new Date(time) ，time 是毫秒级
            tip = this.getLastDate(time);
        }
        return tip;
    }
};

export default Time;