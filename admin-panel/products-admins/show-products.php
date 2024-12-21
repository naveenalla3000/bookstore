<?php require "../includes/header.php"; ?>
    <div class="container-fluid">

          <div class="row">
        <div class="col">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title mb-4 d-inline">Products</h5>
              <a  href="<?php echo ADMINURL;?>/products-admins/create-products.php" class="btn btn-primary mb-4 text-center float-right">Create Products</a>
            
              <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">product</th>
                    <th scope="col">price in $$</th>
                    <th scope="col">category</th>
                    <th scope="col">status</th>
                    <th scope="col">delete</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th scope="row">1</th>
                    <td>python book</td>
                    <td>20</td>
                    <td>development</td>
                     <td><a href="#" class="btn btn-success  text-center ">verfied</a></td>
                     <td><a href="#" class="btn btn-danger  text-center ">delete</a></td>
                  </tr>
                  <tr>
                    <th scope="row">2</th>
                    <td>laravel for advanced devs</td>
                    <td>40</td>
                    <td>development</td>
                    <td><a href="#" class="btn btn-success  text-center ">verfied</a></td>
                    <td><a href="#" class="btn btn-danger  text-center ">delete</a></td>
                  </tr>
                 <tr>
                    <th scope="row">3</th>
                    <td>ruby for stars</td>
                    <td>34</td>
                    <td>development</td>
                    <td><a href="#" class="btn btn-danger  text-center ">unverfied</a></td>
                    <td><a href="#" class="btn btn-danger  text-center ">delete</a></td>
                  </tr>
                </tbody>
              </table> 
            </div>
          </div>
        </div>
      </div>



  </div>
<?php require "../includes/footer.php"; ?>