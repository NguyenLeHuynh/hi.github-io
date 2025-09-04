<?php
// index.php
?>
<!DOCTYPE html>
<html lang="vi">
<head>
  <meta charset="UTF-8">
  <title>TechZone - Cửa hàng công nghệ</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { background: #f8f9fa; }
    .navbar { margin-bottom: 20px; }
    .card { transition: transform 0.2s; }
    .card:hover { transform: scale(1.05); }
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
      <a class="navbar-brand fw-bold" href="#">TechZone</a>
    </div>
  </nav>

  <div class="container">
    <h2 class="mb-4 text-center">Danh sách sản phẩm</h2>
    <div class="row" id="product-list"></div>
  </div>

  <!-- Giỏ hàng -->
  <div class="container mt-5">
    <h3>Giỏ hàng</h3>
    <ul id="cart" class="list-group"></ul>
    <button class="btn btn-success mt-3" onclick="checkout()">Thanh toán</button>
  </div>

  <script>
    let cart = [];
    // Lấy sản phẩm từ API
    fetch("api/products.php")
      .then(res => res.json())
      .then(data => {
        let html = "";
        data.forEach(p => {
          html += `
            <div class="col-md-3 mb-4">
              <div class="card shadow-sm">
                <img src="uploads/${p.image}" class="card-img-top" alt="${p.name}">
                <div class="card-body">
                  <h5 class="card-title">${p.name}</h5>
                  <p class="card-text text-danger fw-bold">${p.price} VNĐ</p>
                  <button class="btn btn-primary" onclick="addToCart(${p.id}, '${p.name}', ${p.price})">Thêm vào giỏ</button>
                </div>
              </div>
            </div>`;
        });
        document.getElementById("product-list").innerHTML = html;
      });

    function addToCart(id, name, price) {
      let item = cart.find(i => i.id === id);
      if (item) {
        item.quantity++;
      } else {
        cart.push({id, name, price, quantity: 1});
      }
      renderCart();
    }

    function renderCart() {
      let html = "";
      cart.forEach(i => {
        html += `<li class="list-group-item d-flex justify-content-between align-items-center">
                  ${i.name} x${i.quantity}
                  <span class="badge bg-danger">${i.price * i.quantity} VNĐ</span>
                 </li>`;
      });
      document.getElementById("cart").innerHTML = html;
    }

    function checkout() {
      if(cart.length === 0) { alert("Giỏ hàng trống!"); return; }

      // Ví dụ customer_id = 1
      fetch("api/orders.php", {
        method: "POST",
        headers: {"Content-Type": "application/json"},
        body: JSON.stringify({customer_id: 1, items: cart})
      })
      .then(res => res.json())
      .then(data => {
        alert(data.message);
        cart = [];
        renderCart();
      });
    }
  </script>
</body>
</html>
