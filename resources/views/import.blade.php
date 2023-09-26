<!DOCTYPE html>
<html>

<head>
    <title>Import Data from Excel</title>
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Latest compiled JavaScript -->
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-3">
                <h1>Import Data from Excel</h1>
                <form action="{{ route('store.import.data') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="file" name="excel_file" class="form-control">
                    <button type="submit" class="btn btn-success mt-3">Import Data</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
