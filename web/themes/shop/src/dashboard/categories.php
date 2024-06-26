<main class="main-content-wrapper">
    <div class="container">
        <!-- row -->
        <div class="row mb-8">
            <div class="col-md-12">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-4">
                    <!-- pageheader -->
                    <div>
                        <h2>Categories</h2>
                        <!-- breacrumb -->
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item"><a href="#" class="text-inherit">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Categories</li>
                            </ol>
                        </nav>
                    </div>
                    <!-- button -->
                    <div>
                        <a href="/shop/categories/new" class="btn btn-primary">Add New Category</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 col-12 mb-5">
                <!-- card -->
                <div class="card h-100 card-lg">
                    <div class="px-6 py-6">
                        <div class="row justify-content-between">
<!--                            <div class="col-lg-4 col-md-6 col-12 mb-2 mb-md-0">-->
<!---->
<!--                            </div>-->
                            <!-- select option -->
                            <div class="col-xl-2 col-md-4 col-12">
                               <button id="actions" class="btn-primary btn">Save changes</button>
                            </div>
                        </div>
                    </div>
                    <!-- card body -->
                    <div class="card-body p-0">
                        <!-- table -->
                        <div class="table-responsive">
                            <table class="table datatable table-centered table-hover mb-0 text-nowrap table-borderless table-with-checkbox">
                                <thead class="bg-light">
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="checkAll">
                                            <label class="form-check-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th>Icon</th>
                                    <th>Name</th>
                                    <th>Product</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(!empty($content['categories'])): ?>
                                 <?php foreach ($content['categories'] as $category): if($category instanceof \Mini\Cms\Modules\Modal\RecordCollection): ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <input <?php echo $category->category_status == 1 ? 'checked' : null; ?> class="form-check-input check-class" type="checkbox" cate="<?= $category->category_id ?>" id="category<?= $category->category_id ?>">
                                            <label class="form-check-label" for="category<?= $category->category_id ?>"></label>
                                        </div>
                                    </td>
                                    <td>
                                        <a href="#!"><img src="<?= \Mini\Modules\contrib\dashboard\src\Modal\Category::categoryImage($category->category_image); ?>" alt="" class="icon-shape icon-sm"></a>
                                    </td>
                                    <td><a href="#" class="text-reset"><?= $category->category_name ?></a></td>
                                    <td>12</td>

                                    <td>
                                        <?php if($category->category_status == '1'): ?>
                                        <span class="badge bg-light-primary text-dark-primary">Published</span>
                                        <?php else: ?>
                                            <span class="badge bg-light-danger text-dark-danger">Unpublished</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endif; endforeach; endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script>
    const actions = document.getElementById('actions');
    if(actions) {
        actions.addEventListener('click',(e)=>{
            e.preventDefault();
            const checkboxes = document.getElementsByClassName('check-class');
            if(checkboxes) {
                const statues = [];
                Array.from(checkboxes).forEach((item)=>{
                    if(item.checked) {
                        const d = {cate_id: item.getAttribute('cate'), status: 1}
                        statues.push(d);
                    }else {
                        const d = {cate_id: item.getAttribute('cate'), status: 0}
                        statues.push(d);
                    }

                })
                if(statues) {
                    const xhr = new XMLHttpRequest();
                    xhr.open('POST', '/shop/categories/update/status',true);
                    xhr.setRequestHeader('Content-Type', 'application/json');
                    xhr.onload = function () {
                        if(this.status === 200) {
                            window.location.reload();
                        }
                    }
                    xhr.send(JSON.stringify(statues))
                }
            }

        })
    }
</script>
