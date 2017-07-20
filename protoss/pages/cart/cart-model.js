import { Base } from '../../utils/base.js';
class Cart extends Base {
  constructor() {
    super();
    this.storageKeyName = 'cart';
  }
  /**添加购物车
   * @item {obj}商品对象
   * @counts {int}商品数目
   */
  add(item, counts) {
    var cartData = this.getCartDataFromLoad();
    var isHasInfo = this._isHasThatOne(item.id, cartData);
    if (isHasInfo.index == -1) {
      item.counts = counts;
      item.selectStatus = true;//设置选中状态
      cartData.push(item);
    } else {
      cartData[isHasInfo.index].counts += counts;
    }
    wx.setStorageSync(this.storageKeyName, cartData)
  }
  /**取本地缓存购物车数据 */
  getCartDataFromLoad() {
    var res = wx.getStorageSync(this.storageKeyName);
    if (!res) {
      return [];
    }
    return res;
  }
  /**计算购物车内商品总数 */
  getCartTotalCounts() {
    var data = this.getCartDataFromLoad();
    var counts = 0;
    for (let i = 0; i < data.length; i++) {
      counts += data[i].counts
    }
    return counts;
  }
  /**判断@arr中是否有@id,判断缓存中是否有该商品 */
  _isHasThatOne(id, arr) {
    var item,
      result = { index: -1 };
    for (let i = 0; i < arr.length; i++) {
      item = arr[i];
      if (item.id == id) {
        result = {
          index: i,
          data: item
        };
        break;
      }
    }
    return result;
  }
}
export { Cart }