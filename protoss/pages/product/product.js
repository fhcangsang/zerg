// product.js
import { Product } from 'product-model.js';
var product = new Product();
Page({

  /**
   * 页面的初始数据
   */
  data: {
    id: null,
    countsArray: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10], //购买数量
    tabsArray: ['商品详情', '产品参数', '售后服务'],
    productCount: 1,
    curentTapIndex: 0
  },

  /**
   * 生命周期函数--监听页面加载
   */
  onLoad: function (options) {
    var id = options.id; //页面回传的商品id
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
  },
  /**购买商品数量 */
  bindPickerChange: function (event) {
    var index = event.detail.value;
    var selectCount = this.data.countsArray[index];
    this.setData({
      productCount: selectCount
    });
  },
  /**tab切换 */
  onTabsItemTap: function (event) {
    var index = product.getDataSet(event, 'index');
    this.setData({
      curentTapIndex: index
    });
  }

})