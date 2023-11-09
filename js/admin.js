 $(document).ready(function() {
        $('#busData').DataTable({
            "order": [
                [1, "asc"],

            ],
            "pageLength": 20,
            "lengthMenu": [
                [10, 20, -1],
                [10, 20, "All"]
            ],
        });
    });

    $(document).ready(function() {
        var table = $('#attendanceTable').DataTable({
                "order": [
                    [10, "desc"],

                ],
                "pageLength": 52, // Set default to 60 rows per page
                "lengthMenu": [
                    [25, 50, 100, -1],
                    [25, 50, 100, "All"]
                ],

                initComplete: function() {
                    this.api().columns().every(function() {
                        var column = this;

                        if ($(column.header()).hasClass('searchable')) {
                            var input = $('<input type="text" class="form-control">')
                                .appendTo($(column.footer()).empty())
                                .on('keyup', function() {
                                    column.search(this.value).draw();
                                });
                        }
                    });

                    $('#routeNoSearch').on('keyup', function() {
                        var routeNo = this.value;
                        table.column(0).search(routeNo === '' ? '' : '^' + routeNo + '$', true,
                            false).draw();
                        calculateSum();
                    });
                },
            }

        );


        //calculate turn count
        function calculateSum() {
            var columnIdxToSum = 13; // Assuming 7th column (index 6) is the column you want to sum
            var filteredData = table.column(columnIdxToSum, {
                "filter": "applied"
            }).data();
            
            var sum = filteredData.reduce(function(acc, curr) {
                return acc + parseFloat(curr);
            }, 0);


            var columnIdxToSum = 12; // Assuming 7th column (index 6) is the column you want to sum
            var filteredData = table.column(columnIdxToSum, {
                "filter": "applied"
            }).data();
            
            var sumTurn = filteredData.reduce(function(acc, curr) {
                return acc + parseFloat(curr);
            }, 0);
            var roundedSum = sum.toFixed(2);
            //document.getElementById('km').value = roundedSum;
            document.getElementById('turncount').value = sumTurn;
            console.log('Sum of column:', sum);
            console.log('Sum of column:', sumTurn);

            
           var column13Data = table.column(13, {page: 'current'}).data(); // Adjust index as needed (assuming 0-based index)
            var column14Data = table.column(14, {page: 'current'}).data(); // Adjust index as needed (assuming 0-based index)

// Sum the values in columns 13 and 14
            var sumColumn13 = column13Data.reduce(function(acc, val) {
            return acc + parseFloat(val);
            }, 0);

            var sumColumn14 = column14Data.reduce(function(acc, val) {
            return acc + parseFloat(val);
            }, 0);

// Sum of columns 13 and 14 for currently shown rows
            var totalSum = sumColumn13 + sumColumn14;

             document.getElementById('km').value = totalSum.toFixed(2);

        }

        calculateSum();
        //SEARCH BETWEEN TWO DATE

        $('#startDate, #endDate').on('change', function() {
            table.draw();
            calculateSum();
        });

        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var startDate = $('#startDate').val();
                var endDate = $('#endDate').val();

                if ((startDate === '' && endDate === '') ||
                    (startDate <= data[6] && endDate >= data[6]) || startDate == data[6]) {
                    return true;
                }

                return false;
            }
        );
    });

    document.addEventListener('DOMContentLoaded', function() {
        const menuItems = document.querySelectorAll('.menu-item');
        const contentSections = document.querySelectorAll('.content > div');
        const menuToggle = document.querySelector('.menu-toggle');
        const menu = document.querySelector('.menu');


        menuToggle.addEventListener('click', function() {
            menu.classList.toggle('default');
            this.classList.toggle('rotate');
        });
        menuItems.forEach(item => {
            item.addEventListener('click', function() {
                const target = this.getAttribute('data-target');
                //alert(target);
                contentSections.forEach(section => {
                    section.classList.remove('active');
                });
                document.querySelector(`.${target}`).classList.add('active');

                menuItems.forEach(menuItem => {
                    menuItem.classList.remove('active');
                });
                this.classList.add('active');
            });
        });
    });



    //edit and move between edit and form

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit');
        var xhr = new XMLHttpRequest();
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                console.log(id);

                xhr.open('GET', '../get_edit_form.php?id=' + id, true);

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        document.getElementById('busData').style.display = 'none';
                        document.getElementById('edit-form').classList.add('show');
                        var response = JSON.parse(xhr.responseText);

                        // Set values to form fields
                        document.querySelector('[name="id"]').value = response.id;
                        document.querySelector('[name="vehicle_no"]').value = response
                            .vehicle_no;
                        document.querySelector('[name="route_no"]').value = response
                            .route_no;
                        document.querySelector('[name="route"]').value = response.route;


                        var type = response.type;

                        // console.log(type);

                        var shiftOption = '';
                        if (type == 'shift') {
                            shiftOption = document.getElementById('shift');
                            shiftOption.setAttribute('selected', 'selected');
                        } else if (type = 'normal') {
                            shiftOption = document.getElementById('normal');
                            shiftOption.setAttribute('selected', 'selected');
                        }

                        document.querySelector('[name="route_distance1"]').value = response
                            .route_distance1;
                        document.querySelector('[name="route_distance2"]').value = response
                            .route_distance2;
                    }
                };

                xhr.send();




            });
        });
    });


    // move attendance table and edit form

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.edit_att');
        var xhr = new XMLHttpRequest();
        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const id = this.getAttribute('data-id');
                console.log(id);

                xhr.open('GET', '../get_edit_form.php?attid=' + id, true);

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        document.getElementById('attendanceTable').style.display = 'none';
                        document.getElementById('att-edit-form').classList.add('show');
                        var response = JSON.parse(xhr.responseText);

                        // Set values to form fields
                        document.querySelector('#formAttEdit [name="attid"]').value =
                            response
                            .id;
                        document.querySelector('#formAttEdit [name="vehicle_no"]').value =
                            response.vehicle_no;
                        document.querySelector('#formAttEdit [name="staff_count"]').value =
                            response.staff_count;

                        document.querySelector('#formAttEdit [name="status"]').value =
                            response.status;

                        /*document.querySelector('#formAttEdit [name="turn_count"]').value =
                            response.turn_count;
*/
                        document.querySelector('#formAttEdit [name="route_distance"]')
                            .value =
                            response.route_distance;

                        console.log(response.route_distance)
                        console.log(response.turn_count);


                        if (response.checked1 === 'checked') {
                            document.querySelector('input[name="driver"]').checked = true;
                        }

                        if (response.checked2 === 'checked') {
                            document.querySelector('input[name="helper"]').checked = true;
                        }

                        document.querySelector('#formAttEdit [name="startTime"]')
                            .value =
                            response.mark_in;
                        
                        document.querySelector('#formAttEdit [name="endTime"]')
                            .value =
                            response.mark_out;



                    }
                };

                xhr.send();




            });
        });
    });


    //delete

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.delete');
        var xhr = new XMLHttpRequest();

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.getAttribute('data-id');
                //console.log(id);

                // Ask for confirmation
                const confirmed = confirm('Are you sure you want to delete this data?');

                if (confirmed) {
                    xhr.open('GET', '../controller/bus_delete_process.php?delid=' + id, true);

                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 400) {

                            //console.log(xhr.responseText);
                            if (xhr.responseText == 'Deleted Succesfully') {
                                alert('Data Deleted Succesfully');
                                window.location.reload();

                            }

                        }
                    };

                    xhr.send();
                }
            });
        });
    });

    //delete att

    document.addEventListener('DOMContentLoaded', function() {
        const editButtons = document.querySelectorAll('.delete_att');
        var xhr = new XMLHttpRequest();

        editButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                const id = this.getAttribute('data-id');
                //console.log(id);

                // Ask for confirmation
                const confirmed = confirm('Are you sure you want to delete this data?');

                if (confirmed) {
                    xhr.open('GET', '../controller/delete_process.php?attdelid=' + id,
                        true);

                    xhr.onload = function() {
                        if (xhr.status >= 200 && xhr.status < 400) {

                            console.log(xhr.responseText);

                            if (xhr.responseText == 'Deleted Succesfully') {

                                alert('Data Deleted Succesfully');

                                location.reload();


                            }

                        }
                    };

                    xhr.send();
                }
            });
        });
    });


    //show table again
    function showTable() {
        document.getElementById('busData').style.display = 'block';
        document.getElementById('edit-form').classList.remove('show');

    }

    function showTableAtt() {
        document.getElementById('attendanceTable').style.display = 'block';
        document.getElementById('att-edit-form').classList.remove('show');

    }
    //showEdit Form function

    // Submit event for edit form


    //edit form update

    document.getElementById('formEdit').addEventListener('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();

        xhr.open('POST', '../controller/bus_process_edit.php', true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                if (xhr.responseText == 'Details Updated Succesfully') {
                    alert(xhr.responseText);
                    window.location.reload();
                }
                console.log(xhr.responseText);
            }
        };

        xhr.send(formData);
    });


    //att edit form update 
    document.getElementById('formAttEdit').addEventListener('submit', function(e) {
        e.preventDefault();

        var formData = new FormData(this);
        var xhr = new XMLHttpRequest();

        xhr.open('POST', '../controller/attendace_update.php', true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                if (xhr.responseText == 'Data Upate Success') {
                    console.log(xhr.responseText);
                    alert(xhr.responseText);
                    window.location.reload();
                }
                //console.log(xhr.responseText);
            }
        };

        xhr.send(formData);
    });


    //add new route

    document.getElementById('route').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', '../controller/bus_process.php', true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                console.log(xhr.responseText);
                var responseText = xhr.responseText;
                if (responseText.includes("This Route No Already Added")) {
                    console.log(xhr.responseText);
                    document.getElementById('errorMsg').style.display = 'block';
                    document.getElementById('successMsg').style.display = 'none';
                    document.getElementById('errorMsg').textContent = responseText;
                } else if (responseText.includes("Success")) {
                    document.getElementById('successMsg').style.display = 'block';
                    document.getElementById('errorMsg').style.display = 'none';
                    document.getElementById('successMsg').textContent = responseText;
                } else {
                    document.getElementById('errorMsg').style.display = 'block';
                    document.getElementById('errorMsg').textContent = responseText;
                }
            } else {
                document.getElementById('errorMsg').style.display = 'block';
            }


            document.getElementById('route').reset();
        };

        xhr.onerror = function() {
            document.getElementById('errorMsg').style.display = 'block';
        };

        xhr.send(formData);
    });

    document.addEventListener('DOMContentLoaded', function() {

        var closeButton = document.querySelector('.btn-close');


        closeButton.addEventListener('click', function() {
            document.getElementById('errorMsg').style.display = 'none';
            document.getElementById('successMsg').style.display = 'none';
        });
    });

    //EXPORT TO EXCELL JAVASCRIPT

    document.getElementById('exportBtn').addEventListener('click', function() {
        var table = document.getElementById('attendanceTable');
        var ws = XLSX.utils.table_to_sheet(table);
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Sheet1');
        var wbout = XLSX.write(wb, {
            bookType: 'xlsx',
            type: 'binary'
        });

        function s2ab(s) {
            var buf = new ArrayBuffer(s.length);
            var view = new Uint8Array(buf);
            for (var i = 0; i != s.length; ++i) view[i] = s.charCodeAt(i) & 0xFF;
            return buf;
        }
        var blob = new Blob([s2ab(wbout)], {
            type: "application/octet-stream"
        });
        var filename = 'Attendance_Data.xlsx';

        // Create an anchor element and trigger a click event
        var a = document.createElement('a');
        a.href = window.URL.createObjectURL(blob);
        a.download = filename;
        a.style.display = 'none';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
    });