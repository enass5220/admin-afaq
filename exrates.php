<!DOCTYPE html>
<html lang="ar">
    <head>
        <?php include 'head.php'?>
        <title>أسعار الصرف</title>
    </head>
<body dir="rtl">
<div class="container-scroller">
    <?php include 'navbar.php';?>
    <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php'?>
        <div class="main-panel" style="direction: rtl;">
            <div class="content-wrapper">
                <div class="row">
                <div class="col-lg-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">أسعار صرف العملة</h4><a href="create_exrate.php" class="btn btn-primary float-start" style="
                                        position: relative;
                                    ">اضافة سعر صرف جديد</a>
                    <p class="card-description"> سعر صرف الدينار الليبي مقابل العملات الأجنبية
                    </p> 
                    <div class="table-responsive mt-3">
                      <table class="table table-hover">
                        <thead>
                          <tr>
                            <th>اسم العملة</th>
                            <th>رمز العملة</th>
                            <th>القيمة مقابل الدينار</th>
                            <th>الحالة</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>الدولار الأمريكي</td>
                            <td>USD</td>
                            <td>5.6</td>
                            <td><label class="badge badge-danger">غير فعال</label></td>
                          </tr>
                          <tr>
                            <td>الدولار الأمريكي</td>
                            <td>USD</td>
                            <td>7.2</td>
                            <td><label class="badge badge-success">فعال</label></td>
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