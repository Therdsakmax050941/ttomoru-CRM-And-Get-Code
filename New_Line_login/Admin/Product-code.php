<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.72.0">
    <title>Admin TTOMORU</title>

    <link rel="canonical" href="https://v5.getbootstrap.com/docs/5.0/examples/album/">



    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/css/bootstrap.min.css" integrity="sha384-r4NyP46KrjDleawBgD5tp8Y7UzmLA05oM1iAEQ17CSuDqnUK2+k9luXQOfXJCJ4I" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha1/js/bootstrap.min.js" integrity="sha384-oesi62hOLfzrys4LxRF63OJCXdXDipiYWBnvTl9Y9/TRlw5xlKIEHpNyvvDShgf/" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/admin.style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</head>

<body>
    <?php include_once './menu.php'; ?>
    <section class="page-content">
        <section class="search-and-user">
            <div class="admin-profile">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
                    <i class="bi bi-bag-plus-fill"></i>
                    เพิ่มรหัสสินค้า
                </button>
                <div class="notifications">
                    <svg>
                    </svg>
                </div>
            </div>
        </section>
        <section>
            <article>
                <div class="card">
                    <div class="table-responsive">
                        <table class="table  mb-0" id="paymentTable">
                            <thead>
                                <tr>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">ID</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Product</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">USER</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">PASSWORD</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">STOCK</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">SYSTEM UPDATE</th>
                                    <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Action</th>
                            </thead>
                            <tbody id="tableBody">
                        </table>
                    </div>
                </div>
            </article>
        </section>
        <!-- Modal -->
        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">สร้างรหัสสินค้า</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="FormCreate">
                            <div class="mb-3">
                                <label for="productname" class="form-label">Product Name</label>
                                <select class="form-select" id="productname" name="productname"></select>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" aria-describedby="email">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password">
                            </div>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">สร้าง</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <footer class="page-footer">
            <span>made by </span>
            <a href="https://georgemartsoukos.com/" target="_blank">
                <img width="50" height="50" src="https://www.idea-initiation.com/wp-content/uploads//2022/11/IDEA-2023-004.svg" alt="George Martsoukos logo">
            </a>
        </footer>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="./assets/js/menu.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./assets/js/main.js"></script>
    <script>
        $(document).ready(function() {
            Product_Code()

            // สร้างการอัปเดตข้อมูลอัตโนมัติทุก 3 วินาที
            setInterval(function() {
                Product_Code()
            }, 3000);
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', fetchPackages);
        window.setTimeout(function() {
            window.location.reload();
        }, 60000);
    </script>
</body>

</html>