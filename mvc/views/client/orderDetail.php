<?php require APP_ROOT . '/views/client/inc/head.php'; ?>

<body>
  <?php
  $cart = new cart();
  if (!isset($_SESSION['cart'])) {
    $total = (isset($cart->getTotalQuantitycart()['total']) ? $cart->getTotalQuantitycart()['total'] : 0);
  } else {
    $total = $cart->getTotal();
  }

  $category = $this->model("categoryModel");
  $result = $category->getAllClient();
  $listCategory = $result->fetch_all(MYSQLI_ASSOC);
  ?>
  <nav class="navbar">
    <div class="logo">HUYPHAM STORE</div>
    <div class="search-container">
      <form action="<?= URL_ROOT ?>/product/search" method="get">
        <input type="text" class="search" placeholder="Tìm kiếm.." name="keyword">
        <button type="submit"><i class="fa fa-search"></i></button>
      </form>
    </div>
    <ul class="nav-links">
      <input type="checkbox" id="checkbox_toggle" />
      <label for="checkbox_toggle" class="hamburger">&#9776;</label>
      <div class="menu">
        <li><a href="<?= URL_ROOT ?>">Trang chủ <i class="fa fa-home"></i></a></li>
        <li class="cate">
          <a href="#">Danh mục <i class="fa fa-list-ul"></i></a>
          <ul class="sub-menu">
            <?php
            foreach ($listCategory as $key) { ?>
              <li><a href="<?= URL_ROOT . '/product/category/' . $key['id'] ?>?page=1"><?= $key['name'] ?></a></li>
            <?php }
            ?>
          </ul>
        </li>

        <?php
        if (isset($_SESSION['user_id'])) { ?>
          <li class="cate menu-active">
            <a href="#"><?= $_SESSION['user_name'] ?> <i class="fa fa-user-circle"></i></a>
            <ul class="sub-menu">
              <li><a href="<?= URL_ROOT . "/user/info" ?>">Thông tin tài khoản <i class="fa fa-user"></i></a></li>
              <li><a href="<?= URL_ROOT . "/product/favorite" ?>">Sản phẩm yêu thích <i class="fa fa-heart"></i></a></li>
              <li><a href="<?= URL_ROOT . "/product/viewed" ?>">Đã xem <i class="fa fa-history"></i></a></li>
              <li><a href="<?= URL_ROOT . "/order/checkout" ?>">Đơn hàng của tôi <i class="fa fa-list-alt"></i></a></li>
              <li><a href="<?= URL_ROOT . "/user/logout" ?>">Đăng xuất <i class="fa fa-sign-out"></i></a></li>
            </ul>
          </li>
        <?php  } else { ?>
          <li><a href="<?= URL_ROOT . "/user/register" ?>">Đăng ký <i class="fa fa-pencil-square"></i></a></li>
          <li><a href="<?= URL_ROOT . "/user/login" ?>">Đăng nhập <i class="fa fa-sign-in"></i></a></li>
        <?php  }
        ?>
        <li><a href="<?= URL_ROOT . "/cart/checkout" ?>" id="bag">Giỏ hàng <i class="fa fa-shopping-bag"></i> (<?= is_null($total) ? 0 : $total ?>)</a></li>
      </div>
    </ul>
  </nav>
  <div class="banner">

  </div>
  <div class="title">Đơn đặt hàng: <?= $data['orderId'] ?></div>
  <table id="table">
    <?php
    $count = 0;
    if (count($data['orderDetailList']) > 0) { ?>
      <tr>
        <th>STT</th>
        <th>Tên sản phẩm</th>
        <th>Hình ảnh</th>
        <th>Số lượng</th>
        <th>Đơn giá</th>
        <?php
        if ($data['status']) { ?>
          <th>Đánh giá</th>
        <?php }
        ?>
      </tr>
      <?php foreach ($data['orderDetailList'] as $key => $value) {
        $total += $value['productPrice'] * $value['qty'];
      ?>
        <tr>
          <td><?= ++$count ?></td>
          <td><a href="<?= URL_ROOT ?>/product/single/<?= $value['productId'] ?>"><?= $value['productName'] ?></a></td>
          <td><img class="img-table" src="<?= URL_ROOT . '/public/images/' . $value['productImage'] ?>" alt=""></td>
          <td><?= $value['qty'] ?></td>
          <td><?= number_format($value['productPrice'], 0, '', ',') ?>₫</td>
          <?php
          if ($data['status']) { ?>
            <td><a href="<?= URL_ROOT ?>/product/rating/<?= $value['productId'] ?>">Xem/Thêm đánh giá</a></td>
          <?php }
          ?>
        </tr>
      <?php }
      ?>
    <?php } else {  ?>
      <h3>Chưa có đơn đặt hàng...</h3>
    <?php }  ?>
  </table>
  <?php require APP_ROOT . '/views/client/inc/footer.php'; ?>
</body>

</html>