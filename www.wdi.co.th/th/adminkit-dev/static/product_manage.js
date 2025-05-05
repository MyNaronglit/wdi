$(document).ready(function () {
    let currentSortOrder = 'DESC'; // เรียงจากใหม่ไปเก่าเริ่มต้น

    function loadOrders(searchQuery = '', sortOrder = 'DESC') {
        $.ajax({
            url: 'order_manage.php',
            method: 'GET',
            data: { action: 'fetch_orders', search: searchQuery, sort: sortOrder },
            dataType: 'json',
            success: function (response) {
                let orderList = $('.order-list ul');
                orderList.empty();

                if (Array.isArray(response) && response.length === 0) {
                    orderList.html('<li class="list-group-item text-center text-muted">No products found.</li>');
                } else if (Array.isArray(response)) {
                    response.forEach(order => {
                        let listItem = $(`
                            <li class="list-group-item d-flex justify-content-between align-items-center order-item"
                                data-product_id="${order.product_id}"
                                style="cursor: pointer; transition: background 0.3s;">
                                <div>
                                    <i class="fa-solid fa-box text-primary"></i>
                                    <strong>${order.product_name}</strong>
                                    <span class="text-muted"> (${order.item_number})</span>
                                </div>
                            </li>
                        `);

                        // Attach click event for order details
                        listItem.click(function () {
                            loadOrderDetails(order.product_id);
                        });

                        orderList.append(listItem);
                    });
                } else {
                    orderList.html('<li class="list-group-item text-center text-muted">Error: Invalid response data.</li>');
                }
            },
            error: function () {
                $('.order-list ul').html('<li class="list-group-item text-center text-muted">Error fetching products.</li>');
            }
        });
    }

    function loadOrderDetails(productId) {
        $('#order-details').html('<p class="text-center text-muted">Loading...</p>');
        $.ajax({
            url: 'order_manage.php',
            method: 'GET',
            data: { action: 'get_order_details', id: productId },
            dataType: 'html',
            success: function (response) {
                $('#order-details').html(response);
            },
            error: function () {
                $('#order-details').html('<p class="text-center text-danger">Error loading order details.</p>');
            }
        });
    }



    $(document).on('click', '.edit-product', function (e) {
        e.preventDefault();
        let productId = $(this).data('product_id');
    
        $.ajax({
            url: 'order_manage.php',
            method: 'GET',
            data: { action: 'get_edit_product', id: productId },
            dataType: 'json',
            success: function (data) {
                console.log('Data received:', data); // ตรวจสอบข้อมูลที่ได้รับ
    
                const getValue = (value, defaultValue = '') => {
                    return (typeof value === 'string' && value.trim() !== '') ? value : defaultValue;
                };
    
                const product = data.product || {}; // ✅ เข้าถึงผ่าน data.product
                const allProducts = Array.isArray(data.all_products) ? data.all_products : [];
    
                console.log('Product object:', product); // ตรวจสอบ object product
    
                // สร้างตัวเลือก category จากข้อมูลทั้งหมด
                const uniqueCategories = [...new Set(allProducts.map(p => p.category))];
                const uniqueCategoryDetails = [...new Set(allProducts.map(p => p.category_detail))];
    
                let categoryOptions = '<option value="">Select Category</option>';
                uniqueCategories.forEach(category => {
                    const selected = category === product.category ? 'selected' : '';
                    categoryOptions += `<option value="${category}" ${selected}>${category}</option>`;
                });
    
                let categoryDetailOptions = '<option value="">Select Category Detail</option>';
                uniqueCategoryDetails.forEach(detail => {
                    const selected = detail === product.category_detail ? 'selected' : '';
                    categoryDetailOptions += `<option value="${detail}" ${selected}>${detail}</option>`;
                });
    
                const statusOptions = ['available', 'out_of_stock', 'discontinued'].map(status => {
                    const selected = product.status === status ? 'selected' : '';
                    return `<option value="${status}" ${selected}>${status.replace('_', ' ').toUpperCase()}</option>`;
                }).join('');
    
                let formDataToSubmit = null;
    
                Swal.fire({
                    title: `Edit Product ID: ${productId}`,
                    html: `
                        <div class="max-w-6xl mx-auto px-4">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-white rounded-2xl shadow-xl">
                                <div class="bg-gray-50 p-6 rounded-xl border shadow-sm">
                                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">🛒 Product Info</h2>
                                    <div class="space-y-5">
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Name</label>
                                            <input id="product_name" class="input-field w-full" value="${getValue(product.product_name)}">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Item Number</label>
                                            <input id="item_number" class="input-field w-full" value="${getValue(product.item_number)}">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700">Status</label>
                                            <select id="status" class="input-field w-full">${statusOptions}</select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                                            <div class="flex gap-3 mb-2">
                                                <button type="button" id="category_select" class="btn-blue">Select</button>
                                                <button type="button" id="category_input" class="btn-gray">Input</button>
                                            </div>
                                            <select id="category_select_element" class="input-field w-full hidden">${categoryOptions}</select>
                                            <input id="category_input_element" class="input-field w-full hidden" value="${getValue(product.category)}">
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Category Detail</label>
                                            <div class="flex gap-3 mb-2">
                                                <button type="button" id="category_detail_select" class="btn-blue">Select</button>
                                                <button type="button" id="category_detail_input" class="btn-gray">Input</button>
                                            </div>
                                            <select id="category_detail_select_element" class="input-field w-full hidden">${categoryDetailOptions}</select>
                                            <input id="category_detail_input_element" class="input-field w-full hidden" value="${getValue(product.category_detail)}">
                                        </div>
                                    </div>
                                </div>
    
                                <div class="bg-gray-50 p-6 rounded-xl border shadow-sm">
                                    <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">⚙️ Additional Info</h2>
                                    <div class="space-y-5">
                                        <div><label class="block font-medium">Lens</label><input id="Lens" class="input-field w-full" value="${getValue(product.Lens)}"></div>
                                        <div><label class="block font-medium">Housing</label><input id="Housing" class="input-field w-full" value="${getValue(product.Housing)}"></div>
                                        <div><label class="block font-medium">Voltage</label><input id="Voltage" class="input-field w-full" value="${getValue(product.Voltage)}"></div>
                                        <div><label class="block font-medium">Number of LEDs</label><input id="No_of_LED" class="input-field w-full" value="${getValue(product.No_of_LED)}"></div>
                                        <div><label class="block font-medium">Function</label><input id="product_function" class="input-field w-full" value="${getValue(product.product_function)}"></div>
                                        <div><label class="block font-medium">Description</label><textarea id="description" class="input-field w-full h-24">${getValue(product.description)}</textarea></div>
    
                                        <div>
                                            <label class="block font-medium">Image</label>
                                            ${product.image_path ? `<img src="${product.image_path}" class="rounded-lg mb-2 max-w-[150px]">` : ''}
                                            <input type="file" id="image" name="image" accept="image/*" class="file-input w-full"value="${getValue(product.image_path)}">
                                        </div>
                                        <div>
                                            <label class="block font-medium">Function Image</label>
                                            ${product.product_func_image ? `<img src="${product.product_func_image}" class="rounded-lg mb-2 max-w-[150px]">` : ''}
                                            <input type="file" id="product_func_image" name="product_func_image" accept="image/*" multiple class="file-input w-full"value="${getValue(product.product_func_image)}">
                                        </div>
                                        <div>
                                            <label class="block font-medium bg-yellow-100 px-2 py-1 rounded">Selected Function Image list:</label>
                                            <ul id="selected_func_image_list" class="mt-2 text-sm text-gray-600 space-y-2"></ul>
                                        </div>
                                        <div>
                                            <label class="block font-medium">More Images</label>
                                            ${Array.isArray(product.detail_images) && product.detail_images.length > 0
                                                ? product.detail_images.map(img => `<img src="${img}" style="max-width: 150px;" class="rounded-lg mb-2 mr-2 inline-block">`).join('')
                                                : '<p class="text-sm text-gray-400">No images available</p>'}
                                            <input type="file" id="image_details" name="image_details[]" accept="image/*" multiple class="file-input w-full">
                                        </div>
                                        <div>
                                            <label class="block font-medium bg-yellow-100 px-2 py-1 rounded">Selected image list:</label>
                                            <ul id="selected_images_list" class="mt-2 text-sm text-gray-600 space-y-2"></ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `,
                    customClass: {
                        popup: 'w-full max-w-7xl'
                    },
                    width: '90%',
                    showCancelButton: true,
                    confirmButtonText: '💾 Save Changes',
                    cancelButtonText: 'Cancel',
                    didOpen: () => {
                        $('#category_select').on('click', () => {
                            $('#category_select_element').removeClass('hidden').show();
                            $('#category_input_element').addClass('hidden').hide();
                        });
                        $('#category_input').on('click', () => {
                            $('#category_input_element').removeClass('hidden').show();
                            $('#category_select_element').addClass('hidden').hide();
                        });
                        $('#category_detail_select').on('click', () => {
                            $('#category_detail_select_element').removeClass('hidden').show();
                            $('#category_detail_input_element').addClass('hidden').hide();
                        });
                        $('#category_detail_input').on('click', () => {
                            $('#category_detail_input_element').removeClass('hidden').show();
                            $('#category_detail_select_element').addClass('hidden').hide();
                        });
                    },
                    preConfirm: () => {
                        const formData = new FormData();
                        formData.append('action', 'update_product');
                        formData.append('product_id', productId);
                        formData.append('product_name', $('#product_name').val());
                        formData.append('item_number', $('#item_number').val());
                        formData.append('status', $('#status').val());
    
                        const category = !$('#category_select_element').hasClass('hidden')
                            ? $('#category_select_element').val()
                            : $('#category_input_element').val();
                        formData.append('category', category);
    
                        const categoryDetail = !$('#category_detail_select_element').hasClass('hidden')
                            ? $('#category_detail_select_element').val()
                            : $('#category_detail_input_element').val();
                        formData.append('category_detail', categoryDetail);
    
                        formData.append('Lens', $('#Lens').val());
                        formData.append('Housing', $('#Housing').val());
                        formData.append('Voltage', $('#Voltage').val());
                        formData.append('No_of_LED', $('#No_of_LED').val());
                        formData.append('product_function', $('#product_function').val());
                        formData.append('description', $('#description').val());
    
                        const imageFile = $('#image')[0].files[0];
                        if (imageFile) formData.append('image', imageFile);
    
                        const funcImages = $('#product_func_image')[0].files;
                        for (let i = 0; i < funcImages.length; i++) {
                            formData.append('product_func_image', funcImages[i]);
                        }
    
                        const detailImages = $('#image_details')[0].files;
                        for (let i = 0; i < detailImages.length; i++) {
                            formData.append('image_details', detailImages[i]);
                        }
    
                        formDataToSubmit = formData;
                        return true;
                    }
                }).then((result) => {
                    if (result.isConfirmed && formDataToSubmit) {
                        $.ajax({
                            url: 'order_manage.php',
                            method: 'POST',
                            data: formDataToSubmit,
                            contentType: false,
                            processData: false,
                            success: function () {
                                Swal.fire('✅ Updated!', 'Product has been updated.', 'success');
                                // 🔄 Optional: refresh product list here
                            },
                            error: function () {
                                Swal.fire('❌ Error', 'Failed to update product.', 'error');
                            }
                        });
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('AJAX Error:', status, error);
                Swal.fire('Error', 'Unable to load product details.', 'warning');
            }
        });
    });
    
/**
 * Event handler for opening the Add Product modal
 * Creates and displays a form for adding new products to the inventory
 */
$(document).on('click', '#openModal-addProduct', function() {
    // Fetch data from the PHP script
    $.ajax({
        url: 'order_manage.php?action=fetch_orders', // Adjust the URL to your PHP file if needed
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response && Array.isArray(response)) {
                // Assuming the PHP script returns an array of product objects
                const uniqueCategories = [...new Set(response.map(product => product.category))]; // Extract unique categories
                const uniqueCategoryDetails = [...new Set(response.map(product => product.category_detail))]; // Extract unique category details

                // Generate options for category dropdown
                let categoryOptions = '<option value="">Select Category</option>';
                uniqueCategories.forEach(category => {
                    categoryOptions += `<option value="${category}">${category}</option>`;
                });

                console.log(uniqueCategories);
                // Generate options for category detail dropdown
                let categoryDetailOptions = '<option value="">Select Category Detail</option>';
                uniqueCategoryDetails.forEach(detail => {
                    categoryDetailOptions += `<option value="${detail}">${detail}</option>`;
                });

                console.log(uniqueCategoryDetails);
                // Initialize SweetAlert modal with product form
                Swal.fire({
                    title: 'Add New Product',
                    html: createProductFormHTML(categoryOptions, categoryDetailOptions),
                    showCancelButton: true,
                    confirmButtonText: 'Add Product',
                    cancelButtonText: 'Cancel',
                    width: '90%', // เพิ่มความกว้างของ Modal
                    preConfirm: validateAndCollectFormData,
                    didOpen: setupImageDetailsEventListeners
                }).then(handleFormSubmission);

                // Set up event listeners for form radio buttons
                setupFormEventListeners();
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error fetching data',
                    text: 'Failed to retrieve product data.',
                });
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching product data:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'An error occurred while fetching data.',
            });
        }
    });
});


/**
 * Creates the HTML content for the product form
 * @param {string} categoryOptions - HTML string of options for category dropdown
 * @param {string} categoryDetailOptions - HTML string of options for category detail dropdown
 * @returns {string} Complete HTML for the product form
 */
function createProductFormHTML(categoryOptions, categoryDetailOptions) {
    return `
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6 p-6 bg-white rounded-xl shadow-xl">
    <!-- Product Info -->
    <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-sm">
        <h2 class="font-semibold text-gray-800 mb-4 border-b pb-2">🛒 Product Info</h2>

        <div class="space-y-4">
            <div class="mb-4 p-2">
                <label for="product_name" class="block font-medium text-gray-700">Name</label>
                <input id="product_name" class="input-field" placeholder="Enter product name">
            </div>
            <div class="mb-4 p-2">
                <label for="item_number" class="block font-medium text-gray-700">Item Number</label>
                <input id="item_number" class="input-field" placeholder="Enter item number">
            </div>
            
            <div class="mb-4 p-2">
                <label for="status" class="block font-medium text-gray-700">Status</label>
                <select id="status" class="input-field">
                    <option value="available">Available</option>
                    <option value="out_of_stock">Out of Stock</option>
                    <option value="discontinued">Discontinued</option>
                </select>
            </div>

           <!-- Latest Release -->
                <div class="latest-release-container">
                <span class="latest-title">Latest Release</span>
                <div class="latest-options">
                    <label class="latest-option">
                    <input type="radio" name="latest_release" value="latest_release">
                    <span>Yes</span>
                    </label>
                    <label class="latest-option">
                    <input type="radio" name="latest_release" value="not_latest">
                    <span>No</span>
                    </label>
                </div>
                </div>

                <div id="Latest_Release" class="branch-container">
                <span class="branch-title">Branch</span>
                <div class="branch-grid">
                    <label class="branch-option">
                    <input type="radio" name="branch" value="WDI">
                    <span>WDI</span>
                    </label>
                    <label class="branch-option">
                    <input type="radio" name="branch" value="Diamond">
                    <span>Diamond</span>
                    </label>
                    <label class="branch-option">
                    <input type="radio" name="branch" value="FITT">
                    <span>FITT</span>
                    </label>
                    <label class="branch-option">
                    <input type="radio" name="branch" value="Faclite">
                    <span>Faclite</span>
                    </label>
                </div>
                </div>


                        </div>
                    </div>
                </div>


                    <!-- Category -->
                    <div class="mb-4 p-2">
                        <label class="block font-medium text-gray-700 mb-4">Category</label>
                        <div class="flex gap-4 mb-4">
                            <button type="button" id="category_select" class="px-6 py-2 font-medium text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition duration-200 ease-in-out">
                                Select
                            </button>
                            <button type="button" id="category_input" class="px-6 py-2 font-medium text-white bg-gray-600 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition duration-200 ease-in-out">
                                Input
                            </button>
                        </div>

                        <select id="category_select_element" class="input-field mt-2 hidden">
                            ${categoryOptions}
                        </select>

                        <input id="category_input_element" class="input-field mt-2 hidden" placeholder="Enter category">

                        <!-- ช่องกรอกยี่ห้อ -->
                        <label id="car_brand_input_label" class="block font-medium text-gray-700 mb-2">Upload brand</label>
                        <input id="car_brand_input" class="input-field mt-2 hidden" placeholder="Enter car brand">
                        <div id="upload_section_brand" class="mt-2 hidden">
                            <input type="file" id="car_image_upload_brand" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                        </div>

                        <!-- ช่องรุ่นรถ -->
                        <label id="car_model_input_label" class="block font-medium text-gray-700 mb-2">Upload model</label>
                        <input id="car_model_input" class="input-field mt-2 hidden" placeholder="Enter car model">
                        <div id="upload_section" class="mt-2 hidden">
                            <input type="file" id="car_image_upload" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"/>
                        </div>
                    </div>


                <!-- Category Detail -->
                <div class="mb-4 p-2">
                    <label id="category_detail_label"  class="block   font-medium text-gray-700 mb-4">Category Detail</label>
                    <div class="flex gap-4 mb-2">
                        <button type="button" id="category_detail_select" class="px-6 py-2   font-medium text-white bg-blue-600 rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300 focus:ring-opacity-50 transition duration-200 ease-in-out">
                            Select
                        </button>
                        <button type="button" id="category_detail_input" class="px-6 py-2   font-medium text-white bg-gray-600 rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300 focus:ring-opacity-50 transition duration-200 ease-in-out">
                            Input
                        </button>
                    </div>
                    <select id="category_detail_select_element" style="display: none;" class="input-field mt-2">${categoryDetailOptions}</select>
                    <input id="category_detail_input_element" style="display: none;" class="input-field mt-2 hidden" placeholder="Enter category detail">
                </div>


            <!-- Additional Info -->
            <div class="bg-gray-50 p-6 rounded-lg border border-gray-200 shadow-sm">
                <h2 class=" font-semibold text-gray-800 mb-4 border-b pb-2">⚙️ Additional Info</h2>

                <div class="space-y-4">
                    <div class="mb-4 p-2"><label for="Lens" class="block   font-medium text-gray-700">Lens</label><input id="Lens" class="input-field" placeholder="Lens details"></div>
                    <div class="mb-4 p-2"><label for="Housing" class="block   font-medium text-gray-700">Housing</label><input id="Housing" class="input-field" placeholder="Housing details"></div>
                    <div class="mb-4 p-2"><label for="Voltage" class="block   font-medium text-gray-700">Voltage</label><input id="Voltage" class="input-field" placeholder="Voltage"></div>
                    <div class="mb-4 p-2"><label for="No_of_LED" class="block   font-medium text-gray-700">Number of LEDs</label><input id="No_of_LED" class="input-field" placeholder="LED count"></div>
                    <div class="mb-4 p-2"><label for="product_function" class="block   font-medium text-gray-700">Function</label><input id="product_function" class="input-field" placeholder="Function"></div>
                    <div class="mb-4 p-2"><label for="description" class="block   font-medium text-gray-700">Description</label><textarea id="description" class="input-field h-24" placeholder="Description"></textarea></div>

                    <!-- File Uploads -->
                    <div class="mb-4 p-2"> 
                        <label class="block   font-medium text-gray-700">Image</label>
                        <input type="file" id="image" name="image" accept="image/*" class="file-input">
                    </div>

                     <div class="mb-4 p-2">
                        <label class="block font-medium text-gray-700">Function Image</label>
                        <input type="file" id="product_func_image_test" name="product_func_image_test" accept="image/*" multiple class="file-input w-full">

                    </div>

                    <div class="mb-4 p-2">
                        <label class="block font-medium text-gray-700" style="background-color: rgb(255, 233, 190)">Selected Function Image list:</label>
                        <ul id="selected_func_image_list" class="mt-2 space-y-2 text-gray-600"></ul>
                    </div>

                    <div class="mb-4 p-2">
                        <label class="block font-medium text-gray-700">More Images</label>
                        <input type="file" id="image_details" name="image_details[]" accept="image/*" multiple class="file-input">
                    </div>

                    <div class="mb-4 p-2">
                        <label class="block font-medium text-gray-700" style="background-color:rgb(255, 233, 190)">Selected image list:</label>
                        <ul id="selected_images_list" class="mt-2 space-y-2 text-gray-600"></ul>
                    </div>

                </div>
            </div>
        </div>
    `;
}

let selectedFuncImageFiles = [];


function setupImageDetailsEventListeners() {
    // Handling selected function images
    const productFuncImageInput = $('#product_func_image_test')[0];
    const selectedFuncImageList = $('#selected_func_image_list');

    $(productFuncImageInput).on('change', function() {
        const files = this.files;
        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                selectedFuncImageFiles.push(file);

                const listItem = $('<li>')
                    .addClass('flex items-center justify-between py-2 px-3 rounded-md bg-gray-100 border border-gray-200');

                const fileName = $('<span>').text(file.name);

                const removeButton = $('<button>')
                    .text('ลบ')
                    .addClass('ml-4 px-3 py-1 bg-red-500 hover:bg-red-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-500')
                    .on('click', function() {
                        const index = selectedFuncImageFiles.indexOf(file);
                        if (index > -1) {
                            selectedFuncImageFiles.splice(index, 1);
                        }
                        listItem.remove();
                    });

                listItem.append(fileName, removeButton);
                selectedFuncImageList.append(listItem);
            }
            // Clear the input value to allow selecting the same file again
            $(this).val('');
        }
    });

    // Handling selected additional images
    const imageDetailsInput = $('#image_details')[0];
    const selectedImagesList = $('#selected_images_list');

    $(imageDetailsInput).on('change', function() {
        const files = this.files;
        if (files.length > 0) {
            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                selectedImageDetailsFiles.push(file);

                const listItem = $('<li>')
                    .addClass('flex items-center justify-between py-2 px-3 rounded-md bg-gray-100 border border-gray-200');

                const fileName = $('<span>').text(file.name);

                const removeButton = $('<button>')
                    .text('ลบ')
                    .addClass('ml-4 px-3 py-1 bg-red-500 hover:bg-red-700 text-white rounded-md focus:outline-none focus:ring-2 focus:ring-red-500')
                    .on('click', function() {
                        const index = selectedImageDetailsFiles.indexOf(file);
                        if (index > -1) {
                            selectedImageDetailsFiles.splice(index, 1);
                        }
                        listItem.remove();
                    });

                listItem.append(fileName, removeButton);
                selectedImagesList.append(listItem);
            }
            // Clear the input value to allow selecting the same file again
            $(this).val('');
        }
    });
}


/**
 * Validates form input and collects form data if valid
 * @returns {FormData|boolean} FormData object if valid, false otherwise
 */
let selectedImageDetailsFiles = [];


function validateAndCollectFormData() {
    const product_name = $('#product_name').val().trim();
    const item_number = $('#item_number').val().trim();
    const status = $('#status').val();
    const description = $('#description').val().trim();
    const imageFile = $('#image')[0].files[0];
    const Lens = $('#Lens').val().trim();
    const Housing = $('#Housing').val().trim();
    const Voltage = $('#Voltage').val().trim();
    const No_of_LED = $('#No_of_LED').val().trim();
    const product_function = $('#product_function').val().trim();
    const car_model_input = $('#car_model_input').val().trim();
    const car_brand_input = $('#car_brand_input').val().trim();

 // Get radio values
 const latest_release = $('input[name="latest_release"]:checked').val() || '';
 const branch = $('input[name="branch"]:checked').val() || '';

 // Get category
 let categoryMode = 'select'; // default
 let categoryDetailMode = 'select';
 
 $('#category_select').click(function () {
     categoryMode = 'select';
     $('#category_select_element').removeClass('hidden');
     $('#category_input_element').addClass('hidden');
 });
 
 $('#category_input').click(function () {
     categoryMode = 'input';
     $('#category_input_element').removeClass('hidden');
     $('#category_select_element').addClass('hidden');
 });
 
 $('#category_detail_select').click(function () {
     categoryDetailMode = 'select';
     $('#category_detail_select_element').show();
     $('#category_detail_input_element').hide();
 });
 
 $('#category_detail_input').click(function () {
     categoryDetailMode = 'input';
     $('#category_detail_select_element').hide();
     $('#category_detail_input_element').show();
 });
 
 // ตอนเก็บค่า:
 let category = (categoryMode === 'select')
     ? $('#category_select_element').val().trim()
     : $('#category_input_element').val().trim();
 
 let category_detail = (categoryDetailMode === 'select')
     ? $('#category_detail_select_element').val().trim()
     : $('#category_detail_input_element').val().trim();
 

    if (!product_name || !item_number) {
        Swal.showValidationMessage('Please fill in all required fields.');
        return false;
    }

    const formData = new FormData();
    formData.append('action', 'add_product');
    formData.append('product_name', product_name);
    formData.append('item_number', item_number);
    formData.append('status', status);
    formData.append('category', category);
    formData.append('description', description);
    formData.append('category_detail', category_detail);
    formData.append('Lens', Lens);
    formData.append('Housing', Housing);
    formData.append('Voltage', Voltage);
    formData.append('No_of_LED', No_of_LED);
    formData.append('product_function', product_function);
    formData.append('latest_release', latest_release);
    formData.append('branch', branch);
    formData.append('car_model_input', car_model_input);
    formData.append('car_brand_input', car_brand_input);

    if (imageFile) {
        formData.append('image', imageFile);
    }

    // ✅ แนบไฟล์จาก selectedFuncImageFiles
    for (let i = 0; i < selectedFuncImageFiles.length; i++) {
        formData.append('product_func_image[]', selectedFuncImageFiles[i]);
    }
    const car_image_upload = $('#car_image_upload')[0].files;
    for (let i = 0; i < car_image_upload.length; i++) {
        formData.append('car_image_upload', car_image_upload[i]);
    }
    const car_image_upload_brand = $('#car_image_upload_brand')[0].files;
    for (let i = 0; i < car_image_upload_brand.length; i++) {
        formData.append('car_image_upload_brand', car_image_upload_brand[i]);
    }

    // ✅ แนบไฟล์จาก selectedImageDetailsFiles
    for (let i = 0; i < selectedImageDetailsFiles.length; i++) {
        formData.append('image_details[]', selectedImageDetailsFiles[i]);
    }

    return formData;
}


function handleFormSubmission(result) {
    if (result.isConfirmed) {
        $.ajax({
            url: 'order_manage.php',
            method: 'POST',
            data: result.value,
            contentType: false,
            processData: false,
            success: function (response) {
                Swal.fire('Success!', 'Product has been added.', 'success').then(() => {
                    // รีเฟรชหน้าเมื่อผู้ใช้กด OK
                    location.reload();
                });
                selectedImageDetailsFiles = [];
                $('#selected_images_list').empty();
            },
            error: function () {
                Swal.fire('Error', 'Failed to add product.', 'error');
            }
        });
    } else {
        selectedImageDetailsFiles = [];
        $('#selected_images_list').empty();
    }
}


function openAddProductModal() {
    Swal.fire({
        title: 'ยืนยันการเพิ่มสินค้า?',
        showCancelButton: true,
        confirmButtonText: 'ยืนยัน',
        cancelButtonText: 'ยกเลิก',
        preConfirm: () => {
            const formData = validateAndCollectFormData();
            if (!formData) return false;
            return formData;
        }
    }).then(handleFormSubmission);
}


/**
 * Sets up event listeners for form elements
 */
function setupFormEventListeners() {
    // Force hide select/input/category sections at start
    $('#category_select_element').addClass('hidden').hide();
    $('#category_input_element').addClass('hidden').hide();
    $('#car_brand_input').addClass('hidden').hide();
    $('#car_brand_input_label').addClass('hidden').hide();
    $('#upload_section_brand').addClass('hidden').hide();
    $('#car_model_input').addClass('hidden').hide();
    $('#car_model_input_label').addClass('hidden').hide();
    $('#upload_section').addClass('hidden').hide();

    $('#category_detail_select_element').addClass('hidden').hide();
    $('#category_detail_input_element').addClass('hidden').hide();

    // Category select / input toggle
    $('#category_select').on('click', function() {
        $('#category_select_element').removeClass('hidden').show();
        $('#category_input_element').addClass('hidden').hide();

        $('#car_model_input').addClass('hidden').hide();
        $('#upload_section').addClass('hidden').hide();
    });

    $('#category_input').on('click', function() {
        $('#category_input_element').removeClass('hidden').show();
        $('#category_select_element').addClass('hidden').hide();

        $('#car_model_input').addClass('hidden').hide();
        $('#upload_section').addClass('hidden').hide();
    });

    // Category detail select / input toggle
    $('#category_detail_select').on('click', function() {
        $('#category_detail_select_element').removeClass('hidden').show();
        $('#category_detail_input_element').addClass('hidden').hide();
    });

    $('#category_detail_input').on('click', function() {
        $('#category_detail_input_element').removeClass('hidden').show();
        $('#category_detail_select_element').addClass('hidden').hide();
    });

    function handleCategoryVisibility(categoryValue) {
        const lowered = categoryValue.trim().toLowerCase();
        const isReplacement = lowered === 'replacement parts';
        const isFitt = lowered === 'accessories (fitt)';

        // Show car model and upload section only for Replacement Parts
        if (isReplacement || isFitt) {
            $('#car_brand_input').removeClass('hidden').show();
            $('#car_brand_input_label').removeClass('hidden').show();
            $('#upload_section_brand').removeClass('hidden').show();
            $('#car_model_input').removeClass('hidden').show();
            $('#car_model_input_label').removeClass('hidden').show();
            $('#upload_section').removeClass('hidden').show();
        } else {
            $('#car_brand_input').addClass('hidden').hide();
            $('#car_brand_input_label').addClass('hidden').hide();
            $('#upload_section_brand').addClass('hidden').hide();
            $('#car_model_input').addClass('hidden').hide();
            $('#car_model_input_label').addClass('hidden').hide();
            $('#upload_section').addClass('hidden').hide();
        }

        // Hide category detail section for Replacement Parts or Accessories (FITT)
        if (isReplacement || isFitt) {
            $('#category_detail_label').addClass('hidden').hide();
            $('#category_detail_select').addClass('hidden').hide();
            $('#category_detail_input').addClass('hidden').hide();
            $('#category_detail_select_element').addClass('hidden').hide();
            $('#category_detail_input_element').addClass('hidden').hide();
        } else {
            $('#category_detail_label').removeClass('hidden').show();
            $('#category_detail_select').removeClass('hidden').show();
            $('#category_detail_input').removeClass('hidden').show();
        }
        
    }

    // From select
    $('#category_select_element').on('change', function() {
        const selectedCategory = $(this).val();
        handleCategoryVisibility(selectedCategory);
    });

    // From input
    $('#category_input_element').on('input', function() {
        const inputCategory = $(this).val();
        handleCategoryVisibility(inputCategory);
    });
}


$(document).ready(function() {
    setupFormEventListeners();
});

    // โหลดข้อมูลเมื่อหน้าเว็บโหลด
    loadOrders();

    // ค้นหาสินค้า
    $('#searchBtn').click(function () {
        let searchTerm = $('#searchInput').val().trim();
        loadOrders(searchTerm, currentSortOrder);
    });

    // เรียงลำดับล่าสุด
    $('#sortLatest').click(function () {
        currentSortOrder = 'DESC';
        loadOrders($('#searchInput').val().trim(), currentSortOrder);
    });

    // เรียงลำดับเก่าสุด
    $('#sortOldest').click(function () {
        currentSortOrder = 'ASC';
        loadOrders($('#searchInput').val().trim(), currentSortOrder);
    });

    
    $(document).on('click', '.delete-product', function (e) {
        e.preventDefault();
        const productId = $(this).data('product_id');
    
        Swal.fire({
            title: 'คุณแน่ใจหรือไม่?',
            text: 'คุณต้องการลบสินค้านี้หรือไม่? การลบจะไม่สามารถย้อนกลับได้',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ใช่, ลบเลย!',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: 'order_manage.php',
                    type: 'POST',
                    data: {
                        action: 'delete_product',
                        product_id: productId 
                    },
                    success: function (res) {
                        let response = JSON.parse(res);
                        if (response.success) {
                            Swal.fire('ลบแล้ว!', response.message, 'success').then(() => {
                                location.reload(); // รีเฟรชหน้าเมื่อผู้ใช้กด OK
                            });
                        } else {
                            Swal.fire('เกิดข้อผิดพลาด!', response.error, 'error');
                        }
                    },
                    error: function () {
                        Swal.fire('ล้มเหลว!', 'ไม่สามารถติดต่อเซิร์ฟเวอร์ได้', 'error');
                    }
                });
            }
        });
    });
    

});

