// pages/address/address.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    num: 1,
    minusStatus: 'disable',
    options: {}
    // items: [
    //   { name: 'wx', value: '微信', checked: 'true'},
    //   { name: 'zfb', value: '支付宝' },
    // ]
  },
  radioChange: function(e) {
    console.log('radio发生change事件，携带value值为：', e.detail.value)
  },
  /*点击减号*/
  bindMinus: function() {
    var num = this.data.num;
    if (num > 1) {
      num--;
    }
    var minusStatus = num > 1 ? 'normal' : 'disable';
    this.setData({
      num: num,
      minusStatus: minusStatus
    })
  },
  /*点击加号*/
  bindPlus: function() {
    var num = this.data.num;
    num++;
    var minusStatus = num > 1 ? 'normal' : 'disable';
    this.setData({
      num: num,
      minusStatus: minusStatus
    })
  },
  /*输入框事件*/
  bindManual: function(e) {
    var num = e.detail.value;
    var minusStatus = num > 1 ? 'normal' : 'disable';
    this.setData({
      num: num,
      minusStatus: minusStatus
    })
  },
  //支付
  pay: function(e) {
    wx.requestPayment({
      'timeStamp': '',
      'nonceStr': '',
      'package': '',
      'signType': 'MD5',
      'paySign': '',
      'success': function(res) {},
      'fail': function(res) {}
    })
  },
  //跳转到添加收货地址页面
  // addAddress:function(e){
  //   wx.navigateTo({
  //     url: '../add-address/add-address'
  //   });
  // },
  //
  addAddress: function() {
    var that = this
    wx.chooseAddress({
      success: function(res) {

        console.log(res)

        var usemessage = res;
        var tokenid = app.gettoken(function (cbdata) {
          tokenid = cbdata.tokenid
          wx.request({
            url: app.globalData.baseurl + "?act=get_address&type=0&tokenid=" + encodeURI(tokenid),
            data: {
              cityName: usemessage.cityName,
              countyName: usemessage.countyName,
              detailInfo: usemessage.detailInfo,
              nationalCode: usemessage.nationalCode,
              postalCode: usemessage.postalCode,
              provinceName: usemessage.provinceName,
              telNumber: usemessage.telNumber,
              userName: usemessage.userName,
            },
            method:"POST",
            header: {
              'content-type': 'application/x-www-form-urlencoded' // 默认值
            },
            success: function (data) {
              console.log("sssdata", data)
              that.getpagedata()
            }
          })
        });


      }

    })

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function(options) {
    this.data.options = options
    this.getpagedata()
  },
  getpagedata: function() {
    var that = this
    var options = that.data.options
    if (options.id > 0 && options.num > 0) {
      var tokenid = app.gettoken(function(cbdata) {
        tokenid = cbdata.tokenid
        wx.request({
          url: app.globalData.baseurl,
          data: {
            act: 'get_goods_order',
            tokenid: encodeURI(tokenid),
            detail_id: options.id,
            num: options.num
          },
          header: {
            'content-type': 'application/json' // 默认值
          },
          success: function(data) {
            console.log("data", data)
            data = data.data;
            that.setData({
              main_title: data.main_title,
              detail_id: data.detail_id,
              discount: data.discount,
              goods_id: data.goods_id,
              main_image: data.main_image,
              name: data.name,
              price: data.price,
              total_price: data.total_price,
              address: data.address,
            })
          }
        })
      });
    }
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function() {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function() {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function() {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function() {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function() {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function() {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function() {

  }
})