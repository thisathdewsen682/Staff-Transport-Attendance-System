document.addEventListener('DOMContentLoaded', function() {
        var markInButtons = document.querySelectorAll('.mark-in');

        markInButtons.forEach(function(button) {
            button.addEventListener('click', function(e) {
                e.preventDefault();

                var routeNo = this.closest('.bus-no').querySelector('input[name="rno"]').value;
                var routeName = this.closest('.bus-no').querySelector('input[name="rname"]')
                    .value;
                var vehicleNo = this.closest('.bus-no').querySelector('input[name="vhno"]')
                    .value;

                var employeeCount = this.closest('.bus-no').querySelector(
                    'input[name="employee_count"]').value;


                //turn count when mark in

                var turnCountIn = this.closest('.bus-no').querySelector(
                    'input[name="turn_count_in"]').value;

                //turn count when mark out
                var turnCountOut = this.closest('.bus-no').querySelector(
                    'input[name="turn_count_out"]').value;


                var driverCheckbox = this.closest('.bus-no').querySelector(
                    'input[name="driver"]');

                var driver = driverCheckbox.checked ? driverCheckbox.value : '0';

                var helperCheckbox = this.closest('.bus-no').querySelector(
                    'input[name="helper"]');
                var helper = helperCheckbox.checked ? helperCheckbox.value : '0';

                //type 

                var type = this.closest('.bus-no').querySelector(
                    'input[name="type"]').value;
                //route distance

                var routeOne = this.closest('.bus-no').querySelector(
                    'input[name="distance_1"]');

                var routeTwo = this.closest('.bus-no').querySelector(
                    'input[name="distance_2"]');

                var routeOneValue = routeOne.value;
                var additionalValue = routeTwo.value;

                console.log(routeOneValue);

                var distanceIn = 0;

                // console.log(routeOne.value);
                if (routeTwo.checked) {
                    if (type == 'shift') {
                        distanceIn = parseFloat(routeOneValue) + parseFloat(additionalValue);
                    } else if (type == 'normal') {
                        distanceIn = (parseFloat(routeOneValue) / 2) + parseFloat(
                            additionalValue);
                    }

                } else {
                    if (type == 'shift') {
                        distanceIn = parseFloat(routeOneValue);
                    } else if (type == 'normal') {
                        distanceIn = (parseFloat(routeOneValue) / 2)
                    }
                }

                console.log(distanceIn);





                //route
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'controller/attendas_mark.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === XMLHttpRequest.DONE) {
                        if (xhr.status === 200) {
                            //console.log(turnCountIn);
                            //console.log(turnCountOut);
                            console.log(xhr.responseText);
                            alert(xhr.responseText);
                            window.location.reload();
                            //button.setAttribute('disabled', 'true');
                        } else {
                            console.error(xhr.responseText);
                        }
                    }
                };

                var data = 'route_no=' + encodeURIComponent(routeNo) +
                    '&route_name=' + encodeURIComponent(routeName) +
                    '&vehicle_no=' + encodeURIComponent(vehicleNo) +
                    '&employee_count=' + encodeURIComponent(employeeCount) +
                    '&turncount_in=' + turnCountIn +
                    '&driver=' + encodeURIComponent(driver) +
                    '&helper=' + encodeURIComponent(helper) +
                    '&distanceIn=' + encodeURIComponent(distanceIn) +
                    '&action=' + 'in';

                xhr.send(data);
            });
        });
    });


    //MARK OUT AJAX

    document.addEventListener('DOMContentLoaded', function() {
        var markOutButtons = document.querySelectorAll('.mark-out');

        markOutButtons.forEach(function(button) {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                var routeNo = this.closest('.bus-no').querySelector('input[name="rno"]').value;
                var turnCountOut = this.closest('.bus-no').querySelector(
                    'input[name="turn_count_out"]').value;

                var type = this.closest('.bus-no').querySelector(
                    'input[name="type"]').value;
                //route distance

                var routeOne = this.closest('.bus-no').querySelector(
                    'input[name="distance_1"]');

                var routeTwo = this.closest('.bus-no').querySelector(
                    'input[name="distance_2"]');

                var routeOneValue = routeOne.value;
                var additionalValue = routeTwo.value;

                console.log(routeOneValue);

                var distanceOut = 0;

                // console.log(routeOne.value);
                if (routeTwo.checked) {
                    if (type == 'shift') {
                        distanceOut = parseFloat(routeOneValue) + parseFloat(additionalValue);
                    } else if (type == 'normal') {
                        distanceOut = (parseFloat(routeOneValue) / 2) + parseFloat(
                            additionalValue);
                    }

                } else {
                    if (type == 'shift') {
                        distanceOut = parseFloat(routeOneValue);
                    } else if (type == 'normal') {
                        distanceOut = (parseFloat(routeOneValue) / 2)
                    }
                }

                //console.log(distanceOut);


                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'controller/attendas_mark.php', true);
                xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        console.log(xhr.responseText)
                        alert(xhr.responseText);
                        window.location.reload();
                    } else {

                        console.log(xhr.responseText);
                    }
                };
                xhr.onerror = function() {

                };


                var data = 'route_no=' + encodeURIComponent(routeNo) +
                    '&action=' + 'out' + '&turncount_out=' + turnCountOut + '&distanceOut=' +
                    distanceOut;

                xhr.send(data);

                //xhr.send('route_no=' + routeNo + '&action=' + 'out');
            });
        });
    });


    //ADD NEW ROUTE AJAX

    document.getElementById('route').addEventListener('submit', function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'controller/bus_process.php', true);

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

    //MARKOUT ALL AJAX

    document.getElementById('markOutAll').addEventListener('click', function() {
            var confirmMarkOut = confirm('Are you sure you want to mark out all vehicles?');
            error = '0';
            if (confirmMarkOut) {

                var unselectedRoutes = [];
                var checkboxes = document.querySelectorAll('.checkbox-markout');

                checkboxes.forEach(function(checkbox) {
                    if (!checkbox.checked) {
                        unselectedRoutes.push(checkbox.value);
                        console.log(unselectedRoutes)
                    }
                });


                //var rnoInputs = document.querySelectorAll('.rno');


                unselectedRoutes.forEach(function(routeNo) {
                        //var routeNo = input.value;
                        var turnCountOut = document.querySelector('input[data-id="' + routeNo +
                            '"][name="turn_count_out"]').value;

                        var type = document.querySelector('input[data-id="' + routeNo +
                            '"][name="type"]').value;

                        var routeOne = document.querySelector('input[data-id="' + routeNo +
                            '"][name="distance_1"]');

                        var routeTwo = document.querySelector('input[data-id="' + routeNo +
                            '"][name="distance_2"]');


                        var routeOneValue = routeOne.value;
                        var additionalValue = routeTwo.value;



                        var distanceOut = 0;

                        // console.log(routeOne.value);
                        if (routeTwo.checked) {
                            if (type == 'shift') {
                                distanceOut = parseFloat(routeOneValue) + parseFloat(additionalValue);
                            } else if (type == 'normal') {
                                distanceOut = (parseFloat(routeOneValue) / 2) + parseFloat(
                                    additionalValue);
                            }

                        } else {
                            if (type == 'shift') {
                                distanceOut = parseFloat(routeOneValue);
                            } else if (type == 'normal') {
                                distanceOut = (parseFloat(routeOneValue) / 2)
                            }
                        }


                        // console.log(turnCountOut);
                        // console.log(type);
                        console.log(routeOneValue);
                        // console.log(additionalValue);
                        console.log(distanceOut);

                        var xhr = new XMLHttpRequest();
                        xhr.open('GET', 'markout_all.php?rno=' + routeNo + '&distanceOut=' + distanceOut +
                            '&turnCountOut=' + turnCountOut, true);

                        xhr.onload = function() {
                            if (xhr.status >= 200 && xhr.status < 400) {
                                if (xhr.status === 200 && xhr.status < 400) {
                                    //console.log(xhr.responseText);
                                    //console.log(routeNo);

                                    requestSuccess = true;

                                } else {
                                    console.error('Request failed:', xhr.status, xhr.statusText);
                                    error = '1';
                                }

                                if (requestSuccess) {
                                    setTimeout(function() {
                                        location.reload();
                                    }, 1000); // Reload after 2 seconds if request was successful
                                    // location.reload();
                                }

                            } else {
                                console.log('1');
                                var error = '1'
                            }
                        };

                        //xhr.open('GET', 'markout_all.php?rno=' + routeNo, true);
                        xhr.send();

                    }

                );

            }
        }

    );

    //CHANGE STYLE AFTER MARKOUT AND MARK IN AJAX

    document.addEventListener('DOMContentLoaded', function() {
        var busElements = document.querySelectorAll('.bus-no');

        busElements.forEach(function(bus) {
            var markOutElement = bus.querySelector('.out');
            var markOutText = markOutElement.innerText;
            var busCard = bus;

            markOutText = markOutText.substr(9);

            if (markOutText.trim() !== '') {
                markOutElement.style.color = 'blue';
                busCard.classList.add('default'); // cheange card color aftert markout
            } else {
                markOutElement.style.color = 'red';
                //busCard.classList.add('marked-in'); // This line is commented out
            }

            // Update the element with the modified text
            markOutElement.innerText = 'Mark Out:' + markOutText;

        });

        var busElementsIn = document.querySelectorAll('.bus-no');

        busElementsIn.forEach(function(bus) {
            var busCard = bus;
            var markOutElement = bus.querySelector('.in');
            var markOutText = markOutElement.innerText;
            //var checkedBox = bus.querySelector('.checkbox-markout');

            // Remove "Mark Out:" using substr
            markOutText = markOutText.substr(8);

            if (markOutText.trim() !== '') {
                markOutElement.style.color = 'green';
                busCard.classList.add('marked-in'); //change color after mark in
            } else {
                //checkedBox.checked = true;
                markOutElement.style.color = 'red';
                busCard.classList.remove(
                    'marked-in'); // remove background color class in default status
            }

            // Update the element with the modified text
            markOutElement.innerText = 'Mark In:' + markOutText;
        });
    });




    /*
        document.addEventListener('DOMContentLoaded', function() {
            var now = new Date();
            var hours = now.getHours();

            if (hours >= 3 AND hours <= 6) {
                // It's after or exactly 3 AM, clear the content

                var busElements = document.querySelectorAll('.bus-no');

                busElements.forEach(function(bus) {
                    var markOutElement = bus.querySelector('.out');
                    markOutElement.innerText = 'Mark Out:';
                    markOutElement.style.color = 'red';

                    var markInElement = bus.querySelector('.in');
                    markInElement.innerText = 'Mark In:';
                    markInElement.style.color = 'red';
                });

            }
        });*/