<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('js/Search.js') }}"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"></link>
    <script rel="stylesheet" src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Product</title>
</head>

<body>

    <div class="container shadow mt-5">

        <div class="mt-3">
            <h1 class="fs-2 text-center">Product</h1>

        </div>


        <div>
            <input type="text" class="form-control align-items-sm-start w-25" id="product-search" placeholder="search product">

            <button id="search-button" class="btn btn-primary ms-1 mt-2">Search</button>

        </div>
        <div class="d-flex justify-content-center" id="display-error">

        </div>

<hr>

        <table class="table table-bordered table-striped table-hover ">
            <thead>
                <tr class="table-primary">
                    <th scope="col">id</th>
                    <th scope="col">product_name</th>
                    <th scope="col">description</th>
                    <th scope="col">price</th>
                    <th scope="col">quantity</th>


                </tr>

     </thead>
            <tbody>

                @foreach ($products as $product)
                <tr>
                    <th >{{$product->id }}</th>
                    <td >{{$product->product_name }}</td>
                    <td >{{$product->description }}</td>
                    <td >{{$product->price }}</td>
                    <td >{{$product->quantity }}</td>
                </tr>
                @endforeach

            </tbody>

        </table>


        <div class="d-flex justify-content-center">
            <span>{{ $products->links('pagination::bootstrap-4') }}</span>
        </div>

    </div>

</body>
</html>
