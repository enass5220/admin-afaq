<!DOCTYPE html>
<html lang="ar">
    <head>
        <?php include 'head.php'?>
        <title>أسعار الشحن</title>
    </head>
<body dir="rtl">
<div class="container-scroller">
    <?php include 'navbar.php';?>
    <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php'?>
        <div class="main-panel">
            <div class="content-wrapper" style="direction: rtl;">
                <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                      <div>
                        <h4 class="card-title">أسعار الشحن</h4> 
                      <p class="card-description"> أسعار خدمات الشحن من مختلف البلدان</p>
                      </div>
                      <div>
                          <a href="create_shippprice.php" class="btn btn-primary btn-icon-text">
                              <i class="mdi mdi-plus btn-icon-prepend"></i>سعر شحن جديد 
                          </a>
                      </div>
                    </div>
                    <div class="table-responsive mt-3">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>عنوان الشحن</th>
                            <th>وحدة القياس</th>
                            <th>السعر</th>
                            <th>الحالة</th>
                            <th>تاريخ الانشاء</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>تركيا - جوي</td>
                            <td>1 kg</td> <!-- join unit measurment for type --->
                            <td>3 USD</td> <!-- join currencys for type --->
                            <td><label class="badge badge-danger">مٌفعل</label></td>
                            <td>15 مايو 2017</td>
                          </tr>
                          <tr>
                          <td>الصين- بحري</td>
                            <td>1 cbm</td>
                            <td>10 USD</td> <!-- join currencys for type --->
                            <td><label class="badge badge-danger">مٌفعل</label></td>
                            <td>15 مايو 2017</td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
                </div>
                <?php include 'footer.php';?>
            </div>
        </div>
    </div>
</div>
<?php include 'js.php';?>
</body>
</html>