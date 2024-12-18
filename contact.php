<?php include('partials-front/menu.php'); ?>
<div class="breadcrumb">
    <a href="index.php">Trang chủ</a> > <span>Liên hệ</span>
</div>
<hr class="divider">
<div class="contact-container">
  <div class="contact-info">
    <div class="contact-item">
      <div class="icon-circle">
        <i class="fas fa-phone-alt"></i>
      </div>
      <p> +(84)904440436</p>
    </div>
    <div class="contact-item">
      <div class="icon-circle">
        <i class="fas fa-envelope"></i>
      </div>
      <p> buithaibao2k4@gmail.com</p>
    </div>
    <div class="contact-item">
      <div class="icon-circle">
        <i class="fas fa-map-marker-alt"></i>
      </div>
      <p>59 Giải Phóng, Đại học xây dựng Hà Nội</p>
    </div>
  </div>
  <hr class="divider">
  <h2>BẢN ĐỒ CỦA CỬA HÀNG</h2>
  <div class="map-container">
  <iframe 
    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3723.972894518751!2d105.84326705162333!3d21.003433672696605!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjEuMDAzNDMzNywgMTA1Ljg0MzI2Nw!5e0!3m2!1svi!2s!4v1700000000" 
    width="100%" 
    height="400" 
    style="border:0;" 
    allowfullscreen="" 
    loading="lazy" 
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>
</div>
<style>
    .breadcrumb {
padding: 10px 20px 0 ;
padding-bottom: 0;
font-size: 14px;
border-radius: 5px;
}

.breadcrumb a {
padding-left: 120px;
text-decoration: none;
color:black;
padding-right: 10px;

}

.breadcrumb a:hover {
text-decoration: underline;
}

.breadcrumb span {
padding-left: 10px;
color: black;
font-size: 14px;
font-weight: bold;
}
h2{
    margin-top: 20px;
    margin-bottom: 20px;
    text-align: center;
}
/* Phần thông tin liên hệ */
.contact-info {
margin-top: 50px;
  display: flex;
  justify-content: center;
  gap: 50px;
  margin-bottom: 30px;
}

.contact-item {
  text-align: center;
  font-size: 16px;
  color: #333;
  padding: 50px;
  max-width :300px;;
}

.icon-circle {
  width: 80px;
  height: 80px;
  background-color: white;
  color: black; 
  border: 2px solid black; 
  border-radius: 50%;
  display: flex;
  justify-content: center; 
  align-items: center; 
  font-size: 24px;
  margin: 0 auto 10px; 
  padding: 50px;
}
.icon-circle:hover{
    background-color: #51AA1B;
}

.contact-item p {
  margin: 0;
  color: black;
}
.contact-item i {
  color: black;
}
.divider {
  border: none;
  border-top: 1px solid #ccc;
  margin: 0;
}
.map-container{
    padding-left: 150px;
    padding-right: 150px;
}

</style>
<?php include('partials-front/footer.php'); ?>