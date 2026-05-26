$(document).ready(function () {

    let blogData = [];
    let currentPage = 1;
    let totalPages = 1;
    let categoryLoaded = false;
    let tagLoaded = false;

    getBlogDetails();

    function getBlogDetails(page = 1)
    {
        startLoader();
    
        $.ajax({
            url: '/get-blog-details?page=' + page,
            type: 'POST',
            contentType: 'application/json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function (res) {
                console.log(res);
    
                stopLoader();
    
                if (res.status) {
    
                    blogData = res.data.data;
                    currentPage = res.data.current_page;
                    totalPages = res.data.last_page;
    
                    renderBlogTable();
                    renderPagination();
    
                } else {
    
                    $(".blog_body").html(`
                        <div class="text-center py-6 text-gray-500">
                            No blogs found
                        </div>
                    `);
    
                    $(".pagination").empty();
                }
            },
            error: function () {
    
                stopLoader();
    
                $(".blog_body").html(`
                    <div class="text-center text-red-500">
                        Failed to load blogs
                    </div>
                `);
            }
        });
    }

    function renderBlogTable()
    {
        let container = $(".blog_body");

        if (!blogData || blogData.length === 0) {
            container.html(`
                <div class="text-center py-6 text-gray-500">
                    No blogs found
                </div>
            `);
            return;
        }
    
        let table = `
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-3 py-3 text-left">ID</th>
                        <th class="px-3 py-3 text-left">Image</th>
                        <th class="px-3 py-3 text-left">Title</th>
                        <th class="px-3 py-3 text-left">Slug</th>
                        <th class="px-3 py-3 text-left">Category</th>
                        <th class="px-3 py-3 text-left">Created At</th>
                        <th class="px-3 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        `;
    
        container.html(table);
    
        let tbody = $(".blog_body tbody");
    
        $.each(blogData, function(index, blog) {
        
            let createdAt = new Date(blog.created_at).toLocaleString('en-IN', {
                day: '2-digit',
                month: 'short',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
        
            let row = `
                <tr class="border-b hover:bg-gray-50">
                    <td class="px-3 py-3">${blog.id}</td>
        
                    <td class="px-3 py-3">
                        <img 
                            src="/${blog.featured_image}" 
                            class="w-12 h-12 rounded object-cover"
                            alt="${blog.title}"
                        >
                    </td>
        
                    <td class="px-3 py-3">
                        ${blog.title}
                    </td>
        
                    <td class="px-3 py-3">
                        ${blog.slug}
                    </td>
        
                    <td class="px-3 py-3">
                        ${blog.category?.name ?? '-'}
                    </td>
        
                    <td class="px-3 py-3 whitespace-nowrap">
                        ${createdAt}
                    </td>
        
                    <td class="px-3 py-3">
                        <div class="flex items-center justify-center gap-3">
        
                            <!-- Edit -->
                            <button
                                class="editBlogBtn text-gray-500 hover:text-blue-600 transition"
                                data-id="${blog.id}"
                                title="Edit Blog"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M11 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                </svg>
                            </button>
        
                            <!-- Delete -->
                            <button
                                class="deleteBlogBtn text-gray-500 hover:text-red-600 transition"
                                data-id="${blog.id}"
                                title="Delete Blog"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="w-5 h-5"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    stroke-width="2">
                                    <path stroke-linecap="round"
                                        stroke-linejoin="round"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h8"/>
                                </svg>
                            </button>
        
                        </div>
                    </td>
                </tr>
            `;
        
            tbody.append(row);
        });
    }


    function renderPagination()
    {
        let pagination = $(".pagination");
    
        pagination.empty();
    
        if(totalPages <= 1) {
            return;
        }
    
        for(let i = 1; i <= totalPages; i++) {
    
            let activeClass =
                i === currentPage
                    ? "bg-blue-500 text-white"
                    : "bg-white";
    
            pagination.append(`
                <li class="page-item px-3 py-1 border rounded cursor-pointer ${activeClass}"
                    data-page="${i}">
                    ${i}
                </li>
            `);
        }
    }


    $(document).on("click", ".page-item", function () {

        let page = $(this).data("page");
    
        getBlogDetails(page);
    });

    $(document).on('click', '#openCreateBlogModal', function () {

        getCategoryDetails();
        getTagDetails();

        $('#createBlogModal')
            .removeClass('hidden')
            .addClass('flex');
    
        $('body').addClass('overflow-hidden');
    
    });
    
   $(document).on('click', '#closeCreateBlogModal, #cancelCreateBlog', function () {

        $('#createBlogModal')
            .addClass('hidden')
            .removeClass('flex');
    
        $('#createBlogForm')[0].reset();
    
        $('#imagePreviewContainer').addClass('hidden');
        $('#imagePreview').attr('src', '');
    
        $('body').removeClass('overflow-hidden');
    
    });
    
    // Close on backdrop click
    $(document).on('click', '#createBlogModal', function (e) {
    
        if (e.target === this) {
    
            $('#createBlogModal')
                .addClass('hidden')
                .removeClass('flex');
    
            $('#createBlogForm')[0].reset();
    
            $('#imagePreviewContainer').addClass('hidden');
            $('#imagePreview').attr('src', '');
    
            $('body').removeClass('overflow-hidden');
        }
    
    });

    $(document).on('click', '#openCreateCategoryModal', function () {

        $('#createCategoryModal')
            .removeClass('hidden')
            .addClass('flex');

        $('body').addClass('overflow-hidden');

    });




    $(document).on(
        'click',
        '#closeCreateCategoryModal, #cancelCreateCategory',
        function () {

            $('#createCategoryModal')
                .addClass('hidden')
                .removeClass('flex');

            $('body').removeClass('overflow-hidden');

        }
    );


    $(document).on('click', '#openCreateCategoryModal', function (e) {

        if ($(e.target).attr('id') === 'createCategoryModal') {

            $('#createCategoryModal')
                .addClass('hidden')
                .removeClass('flex');

            $('body').removeClass('overflow-hidden');

        }

    });

    $(document).on('submit', '#createCategoryForm', function (e) {

        e.preventDefault();

        let form = $(this);

        let submitBtn = form.find('button[type="submit"]');

        $.ajax({
            url: "/set-category-details", 
            type: "POST",
            data: form.serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function () {

                submitBtn.prop('disabled', true);
                submitBtn.text('Saving...');

            },
            success: function (response) {

                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message || 'Category created successfully',
                    confirmButtonText: 'OK'
                });

                form[0].reset();

                $('#createCategoryModal')
                    .addClass('hidden')
                    .removeClass('flex');

                $('body').removeClass('overflow-hidden');

                if (response.category) {

                    $('select[name="category_id"]').append(`
                        <option value="${response.category.id}" selected>
                            ${response.category.name}
                        </option>
                    `);

                }

            },
            error: function (xhr) {

                let errors = xhr.responseJSON?.errors;
                if (errors) {

                    let errorMessages = '';
                    $.each(errors, function (key, value) {

                        errorMessages += value[0] + '\n';

                    });
                    alert(errorMessages);

                } else {

                    alert('Something went wrong');
                }

            },
            complete: function () {

                submitBtn.prop('disabled', false);
                submitBtn.text('Save Category');

            }

        });

    });

    $(document).on('change', 'input[name="featured_image"]', function () {

        let file = this.files[0];
    
        if (!file) {
    
            $('#imagePreviewContainer').addClass('hidden');
            return;
        }
    
        let reader = new FileReader();
    
        reader.onload = function (e) {
    
            $('#imagePreview')
                .attr('src', e.target.result);
    
            $('#imagePreviewContainer')
                .removeClass('hidden');
        };
    
        reader.readAsDataURL(file);
    
    });

    $(document).on("submit", "#createBlogForm", function (e) {
    
        e.preventDefault();
        let form = this;
        let blogId = $(form).attr("data-blog-id");
    
        let url = blogId
            ? "/update-blog-details"
            : "/set-blog-details";
    
        let formData = new FormData(form);
    
        if (blogId) {
            formData.append("id", blogId);
        }
    
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function (response) {
    
                Swal.fire({
                    icon: "success",
                    title: "Success",
                    text: response.message
                });
    
                $("#createBlogModal").addClass("hidden");
    
                $("#createBlogForm")[0].reset();
    
                $("#createBlogForm")
                    .removeAttr("data-blog-id");
    
                getBlogDetails();
            }
        });
    });

    $(document).on('focus', '#category_id', function () {

        if (categoryLoaded) {
            return;
        }
    
        categoryLoaded = true;
    
        getCategoryDetails();
    });

    $(document).on('focus', '#tag_ids', function () {

        if (tagLoaded) {
            return;
        }
    
        tagLoaded = true;
    
        getTagDetails();
    });



    function getCategoryDetails()
    {
        $.ajax({
            url: '/get-category-details',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
    
                if (!response.status) {
                    return;
                }
    
                let options =
                    '<option value="">Select Category</option>';
    
                $.each(response.data, function (index, category) {
    
                    options += `
                        <option value="${category.id}">
                            ${category.name}
                        </option>
                    `;
    
                });
    
                $('#category_id').html(options);
    
            },
            error: function () {
    
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to load categories'
                });
    
            }
        });
    }

    function getTagDetails()
    {
        $.ajax({
            url: '/get-tag-details',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN':
                    $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
    
                if (!response.status) {
                    return;
                }
    
                let options = '';
    
                $.each(response.data, function(index, tag) {
    
                    options += `
                        <option value="${tag.id}">
                            ${tag.name}
                        </option>
                    `;
                });
    
                $('select[name="tags[]"]').html(options);
            }
        });
    }

    $(document).on('click', '#openCreateTagModal', function () {

        $('#createTagModal')
            .removeClass('hidden')
            .addClass('flex');
    
        $('body').addClass('overflow-hidden');
    
    });
    
    $(document).on('click', '#closeCreateTagModal', function () {
    
        $('#createTagModal')
            .addClass('hidden')
            .removeClass('flex');
    
        $('#createTagForm')[0].reset();
    
        $('body').removeClass('overflow-hidden');
    
    });
    
    $(document).on('click', '#cancelCreateTag', function () {
    
        $('#createTagModal')
            .addClass('hidden')
            .removeClass('flex');
    
        $('#createTagForm')[0].reset();
    
        $('body').removeClass('overflow-hidden');
    
    });

    $(document).on('submit', '#createTagForm', function (e) {

        e.preventDefault();
    
        let form = $(this);
        let submitBtn = form.find('button[type="submit"]');
    
        $.ajax({
            url: '/set-tag-details',
            type: 'POST',
            data: form.serialize(),
    
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    
            beforeSend: function () {
    
                submitBtn.prop('disabled', true);
                submitBtn.text('Saving...');
            },
            success: function (response) {
    
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: response.message
                });
    
                form[0].reset();
    
                $('#createTagModal').addClass('hidden');
    
                if (response.tag) {
    
                    $('select[name="tags[]"]').append(`
                        <option value="${response.tag.id}" selected>
                            ${response.tag.name}
                        </option>
                    `);
                }
            },
            error: function (xhr) {
    
                let msg = 'Something went wrong';
    
                if (xhr.responseJSON?.message) {
                    msg = xhr.responseJSON.message;
                }
    
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg
                });
            },
    
            complete: function () {
    
                submitBtn.prop('disabled', false);
                submitBtn.text('Save Tag');
            }
        });
    });


    $(document).on('click', '.deleteBlogBtn', function () {
    
        let blogId = $(this).data('id');
    
        Swal.fire({
            title: 'Delete Blog?',
            text: 'This action cannot be undone.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#dc2626'
        }).then((result) => {
    
            if (!result.isConfirmed) {
                return;
            }
    
            $.ajax({
    
                url: '/delete-blog',
                type: 'POST',
    
                data: {
                    id: blogId
                },
    
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
    
                beforeSend: function () {
                    startLoader();
                },
    
                success: function (response) {
    
                    stopLoader();
    
                    if (response.status) {
    
                        Swal.fire({
                            icon: 'success',
                            title: 'Deleted',
                            text: response.message
                        });
    
                        getBlogDetails(currentPage);
                    }
                    else {
    
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.message
                        });
                    }
                },
    
                error: function () {
    
                    stopLoader();
    
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to delete blog'
                    });
                }
            });
    
        });
    
    });


    $(document).on("click", ".editBlogBtn", function () {

        let blogId = $(this).data("id");
    
        $.ajax({
            url: "/get-blog-by-id",
            type: "POST",
            data: {
                id: blogId
            },
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
            },
            success: function (response) {
    
                if (response.status) {
    
                    let blog = response.blog;
                    console.log(blog);
    
                    $("#createBlogForm").attr(
                        "data-blog-id",
                        blog.id
                    );
    
                    $("input[name='title']").val(blog.title);
                    $("input[name='slug']").val(blog.slug);
                    $("textarea[name='description']").val(blog.description);
    
                    $("select[name='category_id']")
                        .val(blog.category_id);
    
                    $("select[name='tags[]']")
                        .val(
                            blog.tags.map(tag => tag.id)
                        );
    
                    if (blog.featured_image) {
    
                        $("#imagePreview")
                            .attr(
                                "src",
                                "/" + blog.featured_image
                            );
    
                        $("#imagePreviewContainer")
                            .removeClass("hidden");
                    }
    
                    $("#createBlogModal")
                        .removeClass("hidden");
    
                    $("body")
                        .addClass("overflow-hidden");
                }
            }
        });
    });

    $("#openCreateBlogModal").on("click", function () {

        $("#createBlogForm")[0].reset();
    
        $("#createBlogForm")
            .removeAttr("data-blog-id");
    
        $("#imagePreviewContainer")
            .addClass("hidden");
    
        $("#createBlogModal")
            .removeClass("hidden");
    });

});