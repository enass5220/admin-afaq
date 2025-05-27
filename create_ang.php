<!DOCTYPE html>
<html lang="ar">

<head>
    <?php include 'head.php' ?>
    <title>الشحنات | شحنة جديدة (Angular)</title>
    <!-- Add Angular scripts - In a real app, these are bundled by Angular CLI -->
    <!-- For this example, you might need to serve them or use a CDN for quick testing (not recommended for production) -->
    <!-- Example using unpkg for quick demo (replace with your build files) -->
    <script src="https://unpkg.com/core-js-bundle@3.21.1/minified.js"></script>
    <script src="https://unpkg.com/zone.js@0.11.4/dist/zone.min.js"></script>
    <script src="https://unpkg.com/rxjs@7.5.0/dist/bundles/rxjs.umd.min.js"></script>
    <script src="https://unpkg.com/@angular/core@14/bundles/core.umd.min.js"></script>
    <script src="https://unpkg.com/@angular/common@14/bundles/common.umd.min.js"></script>
    <script src="https://unpkg.com/@angular/common@14/bundles/common-http.umd.min.js"></script> <!-- HttpClientModule -->
    <script src="https://unpkg.com/@angular/platform-browser@14/bundles/platform-browser.umd.min.js"></script>
    <script src="https://unpkg.com/@angular/platform-browser-dynamic@14/bundles/platform-browser-dynamic.umd.min.js"></script>
    <script src="https://unpkg.com/@angular/forms@14/bundles/forms.umd.min.js"></script> <!-- FormsModule for ngModel -->

</head>

<body dir="rtl">
    <div class="container-scroller">
        <?php include 'navbar.php'; ?>
        <div class="container-fluid page-body-wrapper">
            <?php include 'sidebar.php' ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <!-- Angular Root Component -->
                    <app-shipment-form></app-shipment-form>
                    <!-- The rest of your PHP footer, etc. -->
                    <?php include 'footer.php'; ?>
                </div>
            </div>
        </div>
    </div>

    <script>
        // --- Basic Angular Application Setup ---
        (function(app) {
            // 1. Define the Component
            app.ShipmentFormComponent =
                ng.core.Component({
                    selector: 'app-shipment-form',
                    template: `
                        <div class="row">
                            <div class="col-10 mx-auto grid-margin stretch-card" style="direction: rtl;">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">شحنة جديدة (Angular)</h4>
                                        <p class="card-description"> انشاء طلبية لزبون </p>
                                        <form (ngSubmit)="onSubmit()" #shipmentForm="ngForm" class="forms-sample p-3 border rounded shadow-sm">

                                            <h5 class="mb-4 border-bottom pb-2">معلومات الزبون والطلب</h5>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="username" class="form-label">اسم المستخدم</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="username" name="username" placeholder="اسم المستخدم"
                                                               [(ngModel)]="shipment.username" required #username="ngModel">
                                                        <button type="button" (click)="lookupUser()" class="btn btn-outline-secondary"><i class="fa fa-search"></i></button>
                                                    </div>
                                                    <div *ngIf="username.invalid && (username.dirty || username.touched)" class="text-danger small mt-1">
                                                        <div *ngIf="username.errors?.['required']">اسم المستخدم مطلوب.</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="orderno" class="form-label">رقم الطلب (Order Number)</label>
                                                    <input type="text" dir="ltr" class="form-control" id="orderno" name="orderno" placeholder="رقم الطلب في shein"
                                                           [(ngModel)]="shipment.orderno" required #orderno="ngModel">
                                                    <div *ngIf="orderno.invalid && (orderno.dirty || orderno.touched)" class="text-danger small mt-1">
                                                        <div *ngIf="orderno.errors?.['required']">رقم الطلب مطلوب.</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="trackno" class="form-label">رقم الشحن (Tracking Number)</label>
                                                    <input type="text" dir="ltr" class="form-control" id="trackno" name="trackno" placeholder="رقم الشحن في shein (اختياري)"
                                                           [(ngModel)]="shipment.trackno">
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="olink" class="form-label">رابط الطلبية / السلة</label>
                                                    <input type="url" dir="ltr" class="form-control" id="olink" name="olink" placeholder="https://..."
                                                           [(ngModel)]="shipment.olink" required #olink="ngModel">
                                                    <div *ngIf="olink.invalid && (olink.dirty || olink.touched)" class="text-danger small mt-1">
                                                        <div *ngIf="olink.errors?.['required']">رابط الطلبية مطلوب.</div>
                                                        <div *ngIf="olink.errors?.['url']">الرابط غير صحيح.</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="my-4">
                                            <h5 class="mb-4 border-bottom pb-2">تفاصيل السعر والشحن</h5>

                                            <div class="row mb-3 align-items-end">
                                                <div class="col-md-6 mb-3">
                                                    <label for="total_price_orig" class="form-label">السعر الإجمالي (العملة الأصلية)</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control" id="total_price_orig" name="total_price_orig" placeholder="150.50"
                                                               [(ngModel)]="shipment.total_price_orig" (ngModelChange)="calculateFinalPrice()" required #total_price_orig="ngModel">
                                                        <select class="input-group-text" name="currency_orig" [(ngModel)]="shipment.currency_orig" (ngModelChange)="calculateFinalPrice()" required>
                                                            <option value="USD">$ دولار</option>
                                                            <option value="EUR">€ يورو</option>
                                                            <option value="TRY">₺ ليرة</option>
                                                            <!-- Add more currencies -->
                                                        </select>
                                                    </div>
                                                     <div *ngIf="total_price_orig.invalid && (total_price_orig.dirty || total_price_orig.touched)" class="text-danger small mt-1">
                                                        <div *ngIf="total_price_orig.errors?.['required']">السعر الأصلي مطلوب.</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 my-auto">
                                                    <label for="exchange_rate" class="form-label">سعر الصرف</label>
                                                    <select class="form-select" dir="ltr" id="exchange_rate" name="exchange_rate"
                                                            [(ngModel)]="shipment.exchange_rate" (ngModelChange)="calculateFinalPrice()" required #exchange_rate_field="ngModel">
                                                        <option value="" selected disabled>-- اختر سعر الصرف --</option>
                                                        <option *ngFor="let rate of availableExchangeRates" [value]="rate.value">{{rate.label}}</option>
                                                    </select>
                                                     <div *ngIf="exchange_rate_field.invalid && (exchange_rate_field.dirty || exchange_rate_field.touched)" class="text-danger small mt-1">
                                                        <div *ngIf="exchange_rate_field.errors?.['required']">سعر الصرف مطلوب.</div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mb-3 align-items-end">
                                                <div class="col-md-6 mb-3">
                                                    <label for="total_price_lyd" class="form-label">السعر النهائي (دينار ليبي)</label>
                                                    <div class="input-group">
                                                        <input type="number" step="0.01" class="form-control" id="total_price_lyd" name="total_price_lyd" placeholder="يتم حسابه تلقائياً"
                                                               [(ngModel)]="shipment.total_price_lyd" readonly>
                                                        <span class="input-group-text">LYD</span>
                                                    </div>
                                                    <small class="form-text text-muted">سيتم تحديثه بناءً على السعر الأصلي وسعر الصرف.</small>
                                                </div>
                                                <div class="col-md-6 my-auto">
                                                    <label for="shipment_method" class="form-label">طريقة الشحن</label>
                                                    <select dir="ltr" class="form-select" id="shipment_method" name="shipment_method"
                                                            [(ngModel)]="shipment.shipment_method" required #shipment_method_field="ngModel">
                                                        <option value="" selected disabled>-- اختر طريقة الشحن --</option>
                                                        <option value="air">شحن جوي</option>
                                                        <option value="sea">شحن بحري</option>
                                                        <option value="express">شحن سريع</option>
                                                    </select>
                                                    <small class="form-text text-muted">سيتم حساب تكلفة الشحن بناءً على الوزن عند الاستلام.</small>
                                                    <div *ngIf="shipment_method_field.invalid && (shipment_method_field.dirty || shipment_method_field.touched)" class="text-danger small mt-1">
                                                        <div *ngIf="shipment_method_field.errors?.['required']">طريقة الشحن مطلوبة.</div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="ostate" class="form-label">حالة الشحنة (للمشرف)</label>
                                                    <select dir="ltr" class="form-select" id="ostate" name="ostate" [(ngModel)]="shipment.ostate">
                                                        <option value="1">تم الانشاء</option>
                                                        <option value="2">وصلت إلى المخزن الخارجي</option>
                                                        <option value="3">وصلت إلى مخزن ليبيا</option>
                                                        <option value="4">جاهز للتسليم</option>
                                                        <option value="5">تم التسليم</option>
                                                    </select>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="payment_status" class="form-label">حالة الدفع</label>
                                                    <select dir="ltr" class="form-select" id="payment_status" name="payment_status" [(ngModel)]="shipment.payment_status">
                                                        <option value="pending">في انتظار الدفع</option>
                                                        <option value="unpaid">غير مدفوعة</option>
                                                        <option value="paid">مدفوعة</option>
                                                        <option value="partial">مدفوعة جزئياً</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            <div *ngIf="submissionMessage" class="alert" [ngClass]="{'alert-success': !submissionError, 'alert-danger': submissionError}">
                                                {{ submissionMessage }}
                                            </div>

                                            <div class="d-flex justify-content-end">
                                                <button type="button" (click)="onCancel()" class="btn btn-light me-3">إلغاء</button>
                                                <button type="submit" class="btn btn-primary" [disabled]="shipmentForm.invalid || isSubmitting">
                                                    <span *ngIf="isSubmitting" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                                    {{ isSubmitting ? 'جاري الإنشاء...' : 'انشاء الطلب' }}
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `
                })
                .Class({
                    constructor: [ng.common.http.HttpClient, function(http) { // Inject HttpClient
                        this.http = http;
                        this.shipment = { // Our form model
                            username: '',
                            orderno: '',
                            trackno: '',
                            olink: '',
                            total_price_orig: null,
                            currency_orig: 'USD', // Default currency
                            exchange_rate: null,
                            total_price_lyd: null,
                            shipment_method: '',
                            ostate: '1', // Default status
                            payment_status: 'pending' // Default payment status
                        };
                        this.availableExchangeRates = [ // Could be fetched from an API
                            { value: '5.50', label: '5.50 LYD/USD' },
                            { value: '5.45', label: '5.45 LYD/USD' },
                            { value: '6.80', label: '6.80 LYD/EUR' }
                        ];
                        this.isSubmitting = false;
                        this.submissionMessage = '';
                        this.submissionError = false;
                    }],
                    ngOnInit: function() {
                        // Initialize anything if needed
                        if (this.availableExchangeRates.length > 0 && !this.shipment.exchange_rate) {
                           // this.shipment.exchange_rate = this.availableExchangeRates[0].value; // Pre-select first rate if desired
                        }
                        this.calculateFinalPrice();
                    },
                    calculateFinalPrice: function() {
                        const priceOrig = parseFloat(this.shipment.total_price_orig);
                        const exchangeRate = parseFloat(this.shipment.exchange_rate);

                        if (!isNaN(priceOrig) && !isNaN(exchangeRate) && exchangeRate > 0) {
                            this.shipment.total_price_lyd = (priceOrig * exchangeRate).toFixed(2);
                        } else {
                            this.shipment.total_price_lyd = null;
                        }
                    },
                    lookupUser: function() {
                        // Placeholder for user lookup logic
                        // This could make an HTTP GET request to a PHP endpoint
                        // e.g., this.http.get('/api/lookup-user.php?username=' + this.shipment.username).subscribe(...)
                        console.log('Looking up user:', this.shipment.username);
                        alert('خاصية البحث عن المستخدم لم تنفذ بعد في هذا المثال.');
                    },
                    onSubmit: function() {
                        if (this.isSubmitting) return;

                        this.isSubmitting = true;
                        this.submissionMessage = '';
                        this.submissionError = false;

                        // Adjust this URL to your actual PHP processing script
                        const backendUrl = 'process_create_shipment.php';

                        this.http.post(backendUrl, this.shipment)
                            .subscribe({
                                next: (response) => {
                                    console.log('Success:', response);
                                    this.submissionMessage = response.message || 'تم إنشاء الطلب بنجاح!';
                                    this.submissionError = !response.success;
                                    this.isSubmitting = false;
                                    if (response.success) {
                                      // Optionally reset the form or redirect
                                      // this.shipment = { ...initialShipmentData }; // Reset form
                                      // window.location.href = '/view_shipment.php?id=' + response.shipmentId;
                                      alert('تم إنشاء الطلب بنجاح! رقم الطلب: ' + (response.shipmentId || 'N/A'));
                                    }
                                },
                                error: (error) => {
                                    console.error('Error:', error);
                                    this.submissionMessage = 'حدث خطأ أثناء إنشاء الطلب. يرجى المحاولة مرة أخرى.';
                                    if(error.error && typeof error.error.message === 'string'){
                                       this.submissionMessage = error.error.message;
                                    } else if (typeof error.message === 'string'){
                                       this.submissionMessage = error.message;
                                    }
                                    this.submissionError = true;
                                    this.isSubmitting = false;
                                }
                            });
                    },
                    onCancel: function() {
                        // Logic for cancel, e.g., redirect or clear form
                        console.log('Form cancelled');
                        // Example: window.location.href = '/dashboard.php';
                        // Or reset form:
                        // this.shipment = { username: '', orderno: '', ... };
                        // this.shipmentForm.resetForm(); // If using #shipmentForm template variable
                        alert('تم إلغاء العملية.');
                    }
                });

            // 2. Define the Module
            app.AppModule =
                ng.core.NgModule({
                    imports: [
                        ng.platformBrowser.BrowserModule,
                        ng.forms.FormsModule, // Import FormsModule for ngModel
                        ng.common.http.HttpClientModule // Import HttpClientModule
                    ],
                    declarations: [app.ShipmentFormComponent],
                    bootstrap: [app.ShipmentFormComponent] // Bootstrap the component
                })
                .Class({
                    constructor: function() {}
                });

            // 3. Bootstrap the Application
            document.addEventListener('DOMContentLoaded', function() {
                ng.platformBrowserDynamic
                    .platformBrowserDynamic().bootstrapModule(app.AppModule)
                    .catch(err => console.error(err));
            });

        })(window.app || (window.app = {}));
    </script>

    <?php include 'js.php'; ?>
</body>
</html>