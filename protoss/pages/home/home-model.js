// home-model.js
import { Base } from '../../utils/base.js';
class Home extends Base {
  constructor() {
    super();
  }
  /**banner */
  getBannerData(id, callback) {
    var params = {
      url: 'banner/' + id,
      sCallback: function (res) {
        callback && callback(res.items);
      }
    }
    this.request(params);
    // wx.request({
    //   url: 'http://test.tp5.com/api/v1/banner/' + id,
    //   method: 'GET',
    //   success: function (res) {
    //     // console.log(res);
    //     callBack(res);
    //   }
    // })
  }
  /**精选主题 */
  getThemeData(callback) {
    var params = {
      url: 'theme?ids=1,2,3',
      sCallback: function (data) {
        callback && callback(data);
      }
    }
    this.request(params);
  }
  /**最近新品 */
  getProductsData(callback) {
    var params = {
      url: 'product/recent?count=13',
      sCallback: function (data) {
        callback && callback(data);
      }
    }
    this.request(params);
  }
}
export { Home }