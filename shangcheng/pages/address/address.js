// pages/address/address.js
const app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    num: 1,
    minusStatus: 'disable',
    // items: [
    //   { name: 'wx', value: '微信', checked: 'true'},
    //   { name: 'zfb', value: '支付宝' },
    // ]
  },
  radioChange: function (e) {
    console.log('radio发生change事件，携带value值为：', e.detail.value)
  },
  /*点击减号*/
  bindMinus: function () {
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
  bindPlus: function () {
    var num = this.data.num;
    num++;
    var minusStatus = num > 1 ? 'normal' : 'disable';
    this.setData({
      num: num,
      minusStatus: minusStatus
    })
  },
  /*输入框事件*/
  bindManual: function (e) {
    var num = e.detail.value;
    var minusStatus = num > 1 ? 'normal' : 'disable';
    this.setData({
      num: num,
      minusStatus: minusStatus
    })
  },
  //支付
  pay:function(e){
    wx.requestPayment({
      'timeStamp': '',
      'nonceStr': '',
      'package': '',
      'signType': 'MD5',
      'paySign': '',
      'success': function (res) {
      },
      'fail': function (res) {
      }
    })
  },
  //跳转到添加收货地址页面
  // addAddress:function(e){
  //   wx.navigateTo({
  //     url: '../add-address/add-address'
  //   });
  // },
  //
  addAddress:function(){
    wx.chooseAddress({
      success: function (res) {

        console.log(res)

        var usemessage = res;

        that.setData({

          usemessage: usemessage

        })

      }

    })

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {

  },

  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  },

  /**
   * 生命周期函数--监听页面显示
   */
  onShow: function () {

  },

  /**
   * 生命周期函数--监听页面隐藏
   */
  onHide: function () {

  },

  /**
   * 生命周期函数--监听页面卸载
   */
  onUnload: function () {

  },

  /**
   * 页面相关事件处理函数--监听用户下拉动作
   */
  onPullDownRefresh: function () {

  },

  /**
   * 页面上拉触底事件的处理函数
   */
  onReachBottom: function () {

  },

  /**
   * 用户点击右上角分享
   */
  onShareAppMessage: function () {

  }
})