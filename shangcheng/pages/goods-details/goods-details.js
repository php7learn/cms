// pages/goods-details/goods-details.js
var app = getApp()
Page({

  /**
   * 页面的初始数据
   */
  data: {
    selectstyle:0, //选择样式
    changesize:0, //选择尺寸
    goodsnumber:0 ,//产品数量
    chooseSize: false,
    animationData: {},
    num: 1,
    minusStatus: 'disable'
  },
  toGoodsComment: function (e) {
    wx.navigateTo({
      url: '../goods-comment/goods-comment'
    });
  },
  confirm: function (e) {
    wx.navigateTo({
      url: '../address/address'
    });
  },
  chooseSize: function (e) {
    // 用that取代this，防止不必要的情况发生
    var that = this;
    // 创建一个动画实例
    var animation = wx.createAnimation({
      // 动画持续时间
      duration: 500,
      // 定义动画效果，当前是匀速
      timingFunction: 'linear'
    })
    // 将该变量赋值给当前动画
    that.animation = animation
    // 先在y轴偏移，然后用step()完成一个动画
    animation.translateY(900).step()
    // 用setData改变当前动画
    that.setData({
      // 通过export()方法导出数据
      animationData: animation.export(),
      // 改变view里面的Wx：if
      chooseSize: true
    })
    // 设置setTimeout来改变y轴偏移量，实现有感觉的滑动
    setTimeout(function () {
      animation.translateY(0).step()
      that.setData({
        animationData: animation.export()
      })
    }, 200)
  },
  // 关闭
  hideModal: function (e) {
    var that = this;
    var animation = wx.createAnimation({
      duration: 1000,
      timingFunction: 'linear'
    })
    that.animation = animation
    animation.translateY(900).step()
    that.setData({
      animationData: animation.export()

    })
    setTimeout(function () {
      animation.translateY(0).step()
      that.setData({
        animationData: animation.export(),
        chooseSize: false
      })
    }, 200)
  },
  //选择
  changeArea: function (data) {
    var that = this;
    var selectstyle = data.currentTarget.dataset.area;
    that.setData({
      "selectstyle": selectstyle
    });
  },
  //选择尺码
  changesize: function (data) {
    var that = this;
    var changesize = data.currentTarget.dataset.area;
    that.setData({
      "changesize": changesize
    });
  },
  //事件处理函数
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
  //弹框
  goodsHeader:function(){
    wx.showActionSheet({
      itemList: ['A', 'B', 'C'],
      success: function (res) {
        console.log(res.tapIndex)
      },
      fail: function (res) {
        console.log(res.errMsg)
      }
    })
  },
  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    console.log("options", options)
    this.loaddata(options.id)
  },
loaddata:function(id){
  var that=this
  var tokenid = app.gettoken(function (cbdata) {
    tokenid = cbdata.tokenid
    wx.request({
      url: app.globalData.baseurl,
      data: {
        act: 'get_goods_info',
        tokenid: encodeURI(tokenid),
        id: id
      },
      header: {
        'content-type': 'application/json' // 默认值
      },
      success: function (data) {
        console.log("data", data)
        data = data.data
        that.setData({
          title:data.title,
          tags:data.tags,
          price:data.price,
          info:data.info,
          image:data.image,
          discount:data.discount
        })
      }
    })
  });
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