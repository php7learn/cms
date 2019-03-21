//app.js
App({
  onLaunch: function () {

   
  },
  globalData: {
    baseurl: 'http://123.56.129.183/api.php',
    login: ""
  },
  gettoken: function (cb) {
    console.log("this.globalData.login", this.globalData.login)
    var timestamp = Date.parse(new Date());
    if (this.globalData.login == '' || this.globalData.login.expires - timestamp < 0) {
      var that = this
      wx.login({
        success: function (res) {
          if (res.code) {
            //发起网络请求
            wx.showNavigationBarLoading(); //打开loading 
            wx.request({
              url: that.globalData.baseurl,
              data: {
                act: "login",
                code: res.code
              },
              success: function (data) {
                wx.hideNavigationBarLoading(); //关闭loading
                that.globalData.login = data.data
                //执行回调
                console.log("gettoken", data.data);
                typeof cb == "function" && cb(data.data)
              }
            })
          } else {
            console.log('登录失败！' + res.errMsg)
          }
        }
      });
    } else {
      //执行回调
      console.log("1_serverdata", this.globalData.login)
      typeof cb == "function" && cb(this.globalData.login)
    }


  }
})