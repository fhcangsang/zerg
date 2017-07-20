// product.js
import { Product } from 'product-model.js';
import { Cart } from '../cart/cart-model.js';
var product = new Product();
var cart = new Cart();
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
      this.setData({
        cartTotalCounts:cart.getCartTotalCounts(),
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
  },
  /**添加购物车 */
  onAddingToCartTap: function (event) {
    this.addToCart();
    var counts = this.data.cartTotalCounts + this.data.productCount;
    this.setData({
      cartTotalCounts: cart.getCartTotalCounts()
    });
  },
  addToCart: function () {
    var tempObj = {};
    var keys = ['id', 'name', 'main_img_url', 'price'];
    for (var key in this.data.product) {
      if (keys.indexOf(key) >= 0) {
        tempObj[key] = this.data.product[key];
      }
    }
    cart.add(tempObj, this.data.productCount);
  }
})