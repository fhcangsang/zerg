// product.js
import { Product } from 'product-model.js';
var product = new Product();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    id:null
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var id = options.id;
    this.data.id = id;
    this._locadData(id);
  },
  _locadData: function (id) {
    product.getProductInfo(id, (res) => {
      console.log(res);
      this.setData({
        product: res
      });
    })
  }












})