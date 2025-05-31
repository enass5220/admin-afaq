<!DOCTYPE html>
<html lang="ar">

<head>
  <?php include 'head.php' ?>
  <title>أسعار الصرف</title>
</head>

<body dir="rtl">
  <div class="container-scroller">
    <?php include 'navbar.php'; ?>
    <div class="container-fluid page-body-wrapper">
      <?php include 'sidebar.php' ?>
      <div class="main-panel" style="direction: rtl;">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex justify-content-between align-items-center">
                    <div>
                      <h4 class="card-title">أسعار صرف العملة</h4>
                      <p class="card-description"> سعر صرف الدينار الليبي مقابل العملات الأجنبية
                      </p>
                    </div>
                    <div>
                      <a href="create_exrate.php" class="btn btn-primary btn-icon-text">
                        <i class="mdi mdi-plus btn-icon-prepend"></i> سعر صرف جديد
                      </a>
                    </div>
                  </div>

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
                      <tbody id="tbody">
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <?php include 'footer.php'; ?>
        </div>
      </div>
    </div>
  </div>
  <?php include 'js.php'; ?>
 <script>
   $(document).ready(function(){
    let searchResultsList = $('#tbody');
  const apiUrl = 'server/select_exrate.php';
  $.ajax({
    url: apiUrl,
    type: 'GET',
    contentType: 'application/json', // Telling the server we're sending JSON
    dataType: 'json', // Expecting JSON response from the server
    success: function(data) {
      if (data && data.length > 0) {
                            data.forEach(function(rates) {
                                let item = `<tr>
                            <td>${rates.name}</td>
                            <td>${rates.code}</td>
                            <td>${rates.rate}</td>`;
                            if(rates.active){
                              item +='<td><span class="badge badge-success">مفعل</span></td>';
                            }else{
                              item +='<td><span class="badge badge-danger">غير فعال</span></td>';
                            }
                            item +='</tr>';
                                searchResultsList.append(item);
                            });
                        } else if (data && data.error) {
                           console.log('خطأ: ' + data.error);
                        } else {
                            searchResultsList.html('<tr><td colspan="4">لم يتم ادخال بيانات بعد.</td></tr>');
                        }
    },
    error: function(jqXHR, textStatus, errorThrown) {
      console.error('Error Status:', textStatus);
      console.error('Error Thrown:', errorThrown);
      console.error('Response Text:', jqXHR.responseText);
    }
    });
  });
 </script>
</body>

</html>