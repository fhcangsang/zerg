//index.js
//获取应用实例
var app = getApp()
var baseUrl = 'http://test.tp5.com/api/v1';
Page({
/*  data: {
    motto: 'Hello World',
    userInfo: {}
  },
  //事件处理函数
  bindViewTap: function () {
    wx.navigateTo({
      url: '../logs/logs'
    })
  },
  onLoad: function () {
    console.log('onLoad')
    var that = this
    //调用应用实例的方法获取全局数据
    app.getUserInfo(function (userInfo) {
      //更新数据
      that.setData({
        userInfo: userInfo
      })
    })
    wx.login({//login流程
      success: function (res) {//登录成功
        if (res.code) {
          var code = res.code;
          console.log(code);
        } else {
          console.log('获取用户登录态失败！' + res.errMsg)
        }
      }
    })
  },*/
  getSuperToken: function () {
    wx.request({
      url: baseUrl + '/token/app',
      data: {
        ac: 'warcraft',
        se: '777'
      },
      method: 'POST',//OPTION,GET,HEAD,POST,PUT,DELETE,TRACE,CONNECT
      //header:{},
      success: function (res) {
        console.log(res.data);
        wx.setStorageSync('super_token', res.data.token);
      },
      fail: function () {
        //fail 
      },
      complete: function () {
        //complete
      }
    })
  },
  getToken: function () {
    //调用登录接口
    wx.login({
      success: function(res) {
        var code = res.code;
        console.log(code);
        wx.request({
          url: baseUrl + '/token/user',
          data: {
            code: code
          },
          method: 'POST',//OPTION,GET,HEAD,POST,PUT,DELETE,TRACE,CONNECT
          //header:{},
          success: function (res) {
            console.log(res.data);
            wx.setStorageSync('token',res.data.token);
          }, fail: function () {
            //fail 
          },
          complete: function () {
            //complete
          }
        })
      }
    })
  },
  pay:function(){
    var token = wx.getStorageSync('token');
    var that = this;
    wx.request({
      url: baseUrl + '/order',
      header:{
        token:token
      },
      data:{
        products:[
          {
            "product_id": 1,
            "count": 3
          },
          {
            "product_id": 2,
            "count": 5
          },
          {
            "product_id": 11,
            "count": 3
          }
        ]
      },
      method: 'POST',//OPTION,GET,HEAD,POST,PUT,DELETE,TRACE,CONNECT
      //header:{},
      success: function (res) {
        console.log(res.data);
      }, 
      fail: function () {
        //fail 
      },
      complete: function () {
        //complete
      }
    });
  },
  checkSession: function (){
    wx.checkSession({
      success: function () { 
        console.log('session seccess');
      },
      fail: function () {
        console.log('session fail');
      },
      complete: function () { },
    })
  }
})