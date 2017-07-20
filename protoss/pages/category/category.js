// category.js
import { Category } from 'category-model.js';
var category = new Category();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    transClassArr: ['tanslate0', 'tanslate1', 'tanslate2', 'tanslate3', 'tanslate4', 'tanslate5'],
    currentMenuIndex: 0,
    loadingHidden: false
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this._loadData();
  },

  _loadData: function (callback) {
    var that = this;
    category.getCategoryType((categoryData) => {
      that.setData({
        categoryTypeArr: categoryData,
        loadingHidden: true
      });
      that.getProductsByCategory(categoryData[0].id, (res) => {
        var dataObj = {
          procucts: res,
          topImgUrl: categoryData[0].img.url,
          title: categoryData[0].name
        }
        that.setData({
          loadingHidden: true,
          categoryInfo0: dataObj
        });
        callback && callback();
      });
    });
  },
  /**切换分类 */
  changeCategory: function (event) {
    var index = category.getDataSet(event, 'index'), //页面点击分类回传的下标
      id = category.getDataSet(event, 'id'); //页面回传的分类id
    this.setData({
      currentMenuIndex: index    //设置当前被选中的下标
    });
    //如果数据是第一次请求
    if (!this.isLoadedData(index)) {
      var that = this;
      this.getProductsByCategory(id, (data) => {
        that.setData(that.getDataObjForBind(index, data));
      });
    }
  },
  isLoadedData: function (index) {
    if (this.data['categoryInfo' + index]) {
      return true;
    }
    return false;
  },

  getDataObjForBind: function (index, data) {
    var obj = {},
      arr = [0, 1, 2, 3, 4, 5],
      baseData = this.data.categoryTypeArr[index];
    for (var item in arr) {
      if (item == arr[index]) {
        obj['categoryInfo' + item] = {
          procucts: data,
          topImgUrl: baseData.img.url,
          title: baseData.name
        };

        return obj;
      }
    }
  },
  /**根据分类id获取分类下商品 */
  getProductsByCategory: function (id, callback) {
    category.getProductsByCategory(id, (data) => {
      callback && callback(data);
    });
  },

  /**跳转到商品详情页 */
  onProductsItemTap: function (event) {
    var id = category.getDataSet(event, 'id');//页面回传的商品id
    wx.navigateTo({
      url: '../product/product?id=' + id,
    })
  },
  /*下拉刷新页面*/
  onPullDownRefresh: function () {
    this._loadData(() => {
      wx.stopPullDownRefresh()
    });
  },

  //分享效果
  onShareAppMessage: function () {
    return {
      title: '零食商贩 Pretty Vendor',
      path: 'pages/category/category'
    }
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  }


})