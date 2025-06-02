<!DOCTYPE html>
<html lang="ar">
    <head>
        <?php include 'head.php'?>
        <title>أسعار الشحن</title>
    </head>
<body >
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
                            <th>#</th>
                            <th>عنوان الشحن</th>
                            <th>وحدة القياس</th>
                            <th>السعر</th>
                            <th>تاريخ الانشاء</th>
                            <th></th>
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
                <?php include 'footer.php';?>
            </div>
        </div>
    </div>
</div>
<?php include 'js.php';?>
<script>
   $(document).ready(function(){
    let searchResultsList = $('#tbody');
  const apiUrl = 'server/select_shipprice.php';
  $.ajax({
    url: apiUrl,
    type: 'GET',
    contentType: 'application/json', // Telling the server we're sending JSON
    dataType: 'json', // Expecting JSON response from the server
    success: function(data) {
        let i=1;
      if (data && data.length > 0) {
                            data.forEach(function(rates) {
                                let item = `<tr>
                                <td>${i++}</td>
                            <td>${rates.address}</td>
                            <td>${rates.unit}</td>
                            <td>${rates.curr}</td>
                            <td>${rates.date}</td>`;
                            item +=`<td><a href="#" class=" btn-outline-info ${rates.id}" >تعديل</a></td>`;
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