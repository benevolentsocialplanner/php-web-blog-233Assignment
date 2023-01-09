<?php include "assets/head.php"; ?>
<title>Add Posts</title>
</head>

<body>


    <?php include "assets/header.php" ?>
    <main role="main" class="main">
        <div class="jumbotron text-center ">
            <h1 class="display-3 font-weight-normal text-muted">Add a Post</h1>
        </div>


        <div class="container">
            <div class="row">

                <div class="col-lg-12 mb-4">

                    <form action="assets/insertPost.php" method="POST" e>


                        <div class="form-group">
                            <label for="title">Title</label>

                            <textarea class="form-control" name="title" id="title" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="desc">desc</label>

                            <textarea class="form-control" name="desc" id="desc" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="body">body</label>

                            <textarea class="form-control" name="body" id="body" required></textarea>
                        </div>


                        <div class="form-group">

                            <label for="writer_name">writer</label>

                            <textarea class="form-control" name="writer_name" id="writer_name" required></textarea>

                            </select>


                        </div>

                        <div class="text-center">
                            <button type="submit" name="submit" class="btn btn-success btn-lg w-25">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <?php include "assets/footer.php" ?>
</body>

</html>