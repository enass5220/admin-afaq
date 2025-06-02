<!DOCTYPE html>
<html lang="ar">
<head>
    <?php include 'head.php'; // Assuming head.php contains meta tags, CSS links etc. ?>
    <title>عناوين الشحن</title>
</head>
<body >
<div class="container-scroller">
    <?php include 'navbar.php'; // Assuming navbar.php contains the top navigation bar ?>
    <div class="container-fluid page-body-wrapper">
        <?php include 'sidebar.php'; // Assuming sidebar.php contains the side navigation ?>
        <div class="main-panel">
            <div class="content-wrapper" style="direction: rtl;">
                <div class="row">
                    <div class="col-lg-12 grid-margin stretch-card">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h4 class="card-title">عناوين الشحن</h4>
                                        <p class="card-description">قائمة بعناوين الشحن المسجلة</p>
                                    </div>
                                    <div>
                                        <a href="create_address.php" class="btn btn-primary btn-icon-text">
                                            <i class="mdi mdi-plus btn-icon-prepend"></i> إضافة عنوان جديد
                                        </a>
                                    </div>
                                </div>
                                <div class="table-responsive mt-3">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>الدولة</th>
                                                <th>نوع الشحن</th>
                                                <th>عنوان الموقع</th>
                                                <th>تاريخ الإنشاء</th>
                                                <th>الحالة</th>
                                                <th>الإجراءات</th>
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
                <?php include 'footer.php'; // Assuming footer.php contains footer content ?>
            </div>
        </div>
    </div>
</div>
<?php include 'js.php'; // Assuming js.php contains JavaScript files ?>
<script>
   $(document).ready(function(){
    let searchResultsList = $('#tbody');
  const apiUrl = 'server/select_address.php';
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
                            <td>${rates.country}</td>`;
                            let typ='';
                            switch(rates.type){
                                case 1: typ='جوي'
                                break;
                                case 2:typ='بحري'
                                break;
                                case 3:typ='بري'
                                break;
                            }
                            item +=`<td>${typ}</td>
                            <td>${rates.address}</td>
                            <td>${rates.created}</td>`;
                            if(rates.active){
                              item +='<td><span class="badge badge-success">مفعل</span></td>';
                            }else{
                              item +='<td><span class="badge badge-danger">غير فعال</span></td>';
                            }
                            item +=`<td><a href="#" class=" btn-outline-info ${typ}" >تعديل</a></td>`;
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