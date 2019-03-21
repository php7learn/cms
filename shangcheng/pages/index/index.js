// pages/index/index.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    // tab 切换
    currentTab: 0,
    top: 0,//导航栏高度
    list:[]
  },
  //导航栏高度
  onPageScroll: function (e) { // 获取滚动条当前位置
    // console.log(e);
    //console.log(e.scrollTop);
    this.setData({
      top: e.scrollTop,
    });
  },
  //点击切换
  clickTab: function (e) {
    var that = this;
    if (this.data.currentTab === e.target.dataset.current) {
      return false;
    } else {
      that.setData({
        currentTab: e.target.dataset.current
      })
    }
  },
  toGoodsDetails:function(e){
    wx.navigateTo({
      url: '../goods-details/goods-details'
    });
  },
  /**
   * 生命周期函数--监听页面加载
   * get_goods_list&catelog=1
   */
  onLoad: function (options) {
    var that=this
    var tokenid = app.gettoken(function (cbdata) {
      tokenid = cbdata.tokenid
      wx.request({
        url: app.globalData.baseurl,
        data: {
          act: 'get_goods_list',
          catelog: 0,
          tokenid: tokenid
        },
        header: {
          'content-type': 'application/json' // 默认值
        },
        success: function (res) {
          var data = res.data
          console.log("data", data)
          that.setData({
            list: res.data
          })
        },
        complete: function () {
          wx.hideLoading()
        }
      })


    })
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