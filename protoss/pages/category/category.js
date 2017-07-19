// category.js
import { Category } from 'category-model.js';
var category = new Category();
Page({

  /**
   * 页面的初始数据
   */
  data: {

  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    this._loadData();
  },

  _loadData: function () {
    category.getCategoryType((categoryData) => {
      this.setData({
        categoryTypeArr: categoryData
      });
      category.getProductsByCategory(categoryData[0].id, (res) => {
        var dataObj = {
          procucts: res,
          topImgUrl: categoryData[0].img.url,
          title: categoryData[0].name
        }
        this.setData({
          productsArr: dataObj
        });
      });
    });
  },
  /**跳转到商品详情页 */
  onProductsItemTap: function (event) {
    var id = category.getDataSet(event, 'id');
    wx.navigateTo({
      url: '../product/product?id=' + id,
    })
  },
  /**
   * 生命周期函数--监听页面初次渲染完成
   */
  onReady: function () {

  }


})