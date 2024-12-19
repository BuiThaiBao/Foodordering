<div class="If_register">
  <div class="block">
  <div class="ifr-content">
    <div class="icon-circle-footer">
      <i class="fas fa-envelope"></i>
      <div class="ifr-content-detail">
        <h3>ĐĂNG KÍ NHẬN TIN</h3>
        <p>Hãy nhận ưu dãi hấp dẫn từ Twelve Food nào !</p>
      </div>
    </div>
  </div>
  <div class="ifr-input">
  <form action="#" class="d-flex" role="send" method="GET">
                    <div class="input-group-footer">
                        <div class="send-container">
                            <input class="form-control" type="send" name="send" placeholder="Email nhận tin"
                                aria-label="Search"
                                value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                            <button class="btn-icon" type="submit">
                                  <p>Gửi</p>
                            </button>
                        </div>
                    </div>
                </form>

  </div>
  </div>
</div>
<footer>
  <div class="footer-container">
    <div class="footer-about">
      <h3>Giới thiệu</h3>
      <p>Chào mừng bạn đến với Twelve Food – điểm đến tuyệt vời cho những tín đồ ẩm thực! Chúng tôi cung cấp các món ăn đa dạng, thơm ngon và hấp dẫn từ nhiều nền ẩm thực khác nhau, với mục tiêu mang đến trải nghiệm ẩm thực tuyệt vời nhất cho mọi khách hàng.

Tại Twelve Food, bạn có thể dễ dàng lựa chọn từ hàng trăm món ăn hấp dẫn, đặt hàng nhanh chóng và tiện lợi ngay trên trang web của chúng tôi. Dù bạn yêu thích các món ăn truyền thống hay các món ăn mới lạ, Twelve Food đều có thể đáp ứng mọi khẩu vị của bạn.
</p>
    </div>

    
    <div class="footer-links">
      <h3>Hỗ trợ khách hàng</h3>
      <ul>
        <li><a href="">Trang chủ</a></li>
        <li><a href="categories.php">Danh mục</a></li>
        <li><a href="foods.php">Sản phẩm</a></li>
        <li><a href="contact.php">Liên hệ</a></li>
        <li><a href="introduce.php">Cửa hàng</a></li>
      </ul>
    </div>


    <div class="footer-contact">
      <h3>Liên hệ</h3>
      <p><i class="fas fa-envelope"></i> Email: buithaibao2k4@gmail.com</p>
      <p><i class="fas fa-phone-alt"></i> Hotline: +(84)904440436</p>
      <p><i class="fas fa-map-marker-alt"></i> Địa chỉ: 59 Giải Phóng, Đại học Xây Dựng Hà Nội</p>
    </div>


    <div class="footer-social">
      <h3>Mạng xã hội</h3>
      <a href="https://www.facebook.com/bao.buithai.167/" class="social-icon"><i class="fab fa-facebook-f"></i></a>
      <a href="https://www.instagram.com/" class="social-icon"><i class="fab fa-instagram"></i></a>
      <a href="#" class="social-icon"><i class="fab fa-twitter"></i></a>
      <a href="#" class="social-icon"><i class="fab fa-youtube"></i></a>
    </div>
  </div>

  <div class="footer-bottom">
    &copy; Bản quyền thuộc về BTB
  </div>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }
    .block{
      display: flex;
    }
    footer {

      color: #fff;
      font-size: 14px;
      line-height: 1.6;
      padding: 20px 0;
      position: relative;
    }
    .footer-container {
      display: flex;
      justify-content: space-around;
      padding: 0 20px;
      border-bottom: 1px solid #555;
      flex-wrap: wrap;
      gap: 20px;
    }
    .footer-about,
    .footer-links,
    .footer-contact,
    .footer-social {
      flex: 1 1 200px;
      margin: 10px;
      text-align: left;
    }

   
    .footer-about h3,
    .footer-links h3,
    .footer-contact h3,
    .footer-social h3 {
      margin-bottom: 10px;
      font-size: 16px;
      color: black;
    }

    .footer-links ul {
      list-style: none;
      padding: 0;
    }

    .footer-links ul li {
      margin-bottom: 8px;
    }

    .footer-links ul li a {
      color: #8F8F8F;
      text-decoration: none;
    }

    .footer-links ul li a:hover {
      color: #428B16;
    }

    .footer-contact p:hover {
      color: #428B16;
    }

    .footer-contact p i :hover {
      color: #428B16;
    }

    .footer-social .social-icon {
      display: inline-block;
      margin: 5px 0;
      color: #8F8F8F;
      text-decoration: none;
      font-weight: bold;
    }

    .footer-social .social-icon:hover {
      color: #428B16;
    }


    .footer-bottom {
      text-align: center;
      padding: 10px 0;
      font-size: 12px;
      color: #aaa;
      border-top: 1px solid #555;
    }

    .footer-social .social-icon {
      display: inline-flex;
      align-items: center;
      margin: 5px 0;
      color: #8F8F8F;
      text-decoration: none;
      font-weight: bold;
      gap: 5px;
      transition: color 0.3s ease;
    }

    .footer-social .social-icon:hover {
      color: #428B16;
    }

    .footer-social .social-icon i {
      font-size: 18px;
    
    }

    p {
      color: #8F8F8F;
    }

    .If_register {
      width: 100%;
      height: 100px;
      background-color: #F9C938;
      padding-left: 80px;
    }

    .icon-circle-footer {
      display: flex;
      height: 100px;
      align-items: center;
      padding-left: 100px;
    }

    .icon-circle-footer i {
      width: 60px;
      height: 60px;
      background-color: white;
      color: black;
      border: 2px;
      border-radius: 50%;
      display: flex;
      justify-content: center;
      align-items: center;
      font-size: 24px;
    }

    .ifr-content-detail {
      padding-left: 20px;
      margin-top: 25px;
      margin-bottom: 0px;
    }

    .ifr-content-detail h3 {
      margin-bottom: 0px;
      font-size: 24px;
      color: black;
    }

    .ifr-content-detail p {
      color: black;
    }


    .footer-contact p {
      display: flex;
      align-items: center;
      color: #8F8F8F;
      gap: 8px;
      font-size: 14px;
    }

    .footer-contact i {
      color: #8F8F8F;
      font-size: 18px;
    }
    input.form-control{
      border-radius: 50px !important;
      border: none;
      height: 55px;
      width: 450px;
    }
    .input-group-footer{
      padding-top: 24px;
      border: none;
    }
    .btn-icon{
      height: 55px;
      width: 125px;
      background-color:#51aa1b;
      position: relative;
      border-radius: 0 50px 50px 0;
      top : -55px;
      left : 365px;
      border: none;
    }
    .btn-icon p {
      color: white;
      justify-content: center;
      align-items: center;
      padding-top: 18px;
    }
    .send-container{
      padding-left: 250px;
    }
  </style>
</footer>