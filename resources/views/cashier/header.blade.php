
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Responsive Admin &amp; Dashboard Template based on Bootstrap 5">
    <meta name="author" content="AdminKit">
    <meta name="keywords" content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('img/icons/icon-48x48.png') }}" />

    @stack('css')

    <title>Admin | Ideal Study</title>

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/new-style.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>

<body>
<div class="wrapper">
    <nav id="sidebar" class="sidebar js-sidebar">
        <div class="sidebar-content js-simplebar">
            <a class="sidebar-brand" href="/cashier/home">
                <span class="align-middle">Ideal Study <br>O'quv markazi</span>
            </a>

            <ul class="sidebar-nav">


                <li class="sidebar-item @yield('home')">
                    <a class="sidebar-link" href="{{ route('cashier.home') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down-circle align-middle"><circle cx="12" cy="12" r="10"></circle><polyline points="8 12 12 16 16 12"></polyline><line x1="12" y1="8" x2="12" y2="16"></line></svg> <span class="align-middle">To'lov</span>
                    </a>
                </li>




                <li class="sidebar-header">
                    Boshqaruv
                </li>

                <li class="sidebar-item @yield('classes')">
                    <a class="sidebar-link" href="{{ route('cashier.classes') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid align-middle"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg> <span class="align-middle">Sinflar</span>
                    </a>
                </li>

                <li class="sidebar-item @yield('students')">
                    <a class="sidebar-link" href="{{ route('cashier.students') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-users align-middle"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg> <span class="align-middle">O'quvchilar</span>
                    </a>
                </li>

                <li class="sidebar-item @yield('outlays')">
                    <a class="sidebar-link" href="{{ route('cashier.outlays') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-circle align-middle"><circle cx="12" cy="12" r="10"></circle><polyline points="16 12 12 8 8 12"></polyline><line x1="12" y1="16" x2="12" y2="8"></line></svg> <span class="align-middle">Xarajatlar</span>
                    </a>
                </li>


                <li class="sidebar-header">
                    Malumotlar
                </li>

                <li class="sidebar-item @yield('payments')">
                    <a class="sidebar-link" href="{{ route('cashier.payments.all') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bar-chart-2 align-middle"><line x1="18" y1="20" x2="18" y2="10"></line><line x1="12" y1="20" x2="12" y2="4"></line><line x1="6" y1="20" x2="6" y2="14"></line></svg> <span class="align-middle">To'lovlar</span>
                    </a>
                </li>

                <li class="sidebar-item @yield('attendance')">
                    <a class="sidebar-link" href="{{ route('cashier.attendance.subjects') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check align-middle"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg> <span class="align-middle">Davomat</span>
                    </a>
                </li>

                <li class="sidebar-item @yield('statistics')">
                    <a class="sidebar-link" href="{{ route('export.payments') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase align-middle me-2"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg> <span class="align-middle">Statistika</span>
                    </a>
                </li>

                <li class="sidebar-item @yield('statistics')">
                    <a class="sidebar-link" href="{{ route('export.payments.debt') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-triangle align-middle me-2"><path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg> <span class="align-middle">Qarzdorlar</span>
                    </a>
                </li>

                <li class="sidebar-item @yield('salaries')">
                    <a class="sidebar-link" href="{{ route('cashier.salaries') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-share align-middle me-2"><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"></path><polyline points="16 6 12 2 8 6"></polyline><line x1="12" y1="2" x2="12" y2="15"></line></svg> <span class="align-middle">Oldindan oylik</span>
                    </a>
                </li>

                <li class="sidebar-header">
                    Xizmatlar
                </li>
                <li class="sidebar-item @yield('sms')">
                    <a class="sidebar-link" href="{{ route('cashier.sms') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-circle align-middle"><path d="M21 11.5a8.38 8.38 0 0 1-.9 3.8 8.5 8.5 0 0 1-7.6 4.7 8.38 8.38 0 0 1-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 0 1-.9-3.8 8.5 8.5 0 0 1 4.7-7.6 8.38 8.38 0 0 1 3.8-.9h.5a8.48 8.48 0 0 1 8 8v.5z"></path></svg> <span class="align-middle">Sms xizmati</span>
                    </a>
                </li>

                <li class="sidebar-header">
                    Profil
                </li>
                <li class="sidebar-item @yield('profile')">
                    <a class="sidebar-link" href="{{ route('cashier.profile') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user align-middle"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg> <span class="align-middle">Profil</span>
                    </a>
                </li>
            </ul>


        </div>
    </nav>

    <div class="main">
        <nav class="navbar navbar-expand navbar-light navbar-bg">
            <a class="sidebar-toggle js-sidebar-toggle">
                <i class="hamburger align-self-center"></i>
            </a>
            <form class="d-sm-inline-block">
                <div class="input-group input-group-navbar">
                    <input type="text" id="modalSearchInput" class="form-control" placeholder="Search…" aria-label="Search">
                    <button class="btn" type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search align-middle"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                    </button>
                </div>
            </form>
            <div class="navbar-collapse collapse">
                <ul class="navbar-nav navbar-align">

                    <li class="nav-item">
                        <a class="nav-icon d-none d-lg-block" href="#" id="fullscreenLink">
                            <div class="position-relative">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-maximize align-middle"><path d="M8 3H5a2 2 0 0 0-2 2v3m18 0V5a2 2 0 0 0-2-2h-3m0 18h3a2 2 0 0 0 2-2v-3M3 16v3a2 2 0 0 0 2 2h3"></path></svg>
                            </div>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                            <i class="align-middle" data-feather="settings"></i>
                        </a>

                        <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                            <img src="{{ asset('/img/avatars/') }}/{{ session('photo') }}" class="avatar img-fluid rounded me-1" alt="user photo" /> <span class="text-dark">{{ session('name') }}</span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a class="dropdown-item" href="{{ route('cashier.profile') }}"><i class="align-middle me-1" data-feather="user"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('cashier.logout') }}">Chiqish</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <div class="h-100" id="search-section" style="display: none">

        </div>

        <div class="h-100" id="main">
            @yield('section')
        </div>


        <footer class="footer">
            <div class="container-fluid">
                <div class="row text-muted">
                    <div class="col-6 text-start">
                        <p class="mb-0">
                            <a class="text-muted" href="#" target="_blank"><strong>Ideal Study</strong></a> - <a class="text-muted" href="#" target="_blank"><strong>O'quv markazi</strong></a>								&copy;
                        </p>
                    </div>
                    <div class="col-6 text-end">
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <a class="text-muted" href="https://t.me/Samandar_developer" target="_blank">Dasturchi: <span class="text-primary">Samandar Sariboyev</span></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js" integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@yield('js')
<script>
    // Handle search input in modal
    $('#modalSearchInput').on('input', function() {
        var query = $(this).val();
        var loadingIndicator = $('#loadingIndicator');
        if (query.length === 0){
            $('#main').show();
            $('#search-section').hide();
        }
        if(query.length > 2){
            $('#search-section').empty();
            $.ajax({
                url: '{{ route('cashier.search') }}', // Replace with your backend route for handling search
                method: 'GET',
                data: { name: query },
                success: function(response) {
                    console.log(response);
                    var references = response; // Assign the response directly
                    var referencesHtml =
                        `<main class="content teachers">
                        <div class="container-fluid p-0">
                            <div class="col-12 col-xl-12">
                                <div class="card">
                                    <div class="card-header d-flex justify-content-between">
                                        <h5 class="card-title mb-0">O'quvchilar ro'yhati</h5>
                                        <button class="btn btn-primary add ms-2">+ Yangi o'quvchi</button>
                                    </div>
                                    <table class="table table-striped table-hover table-responsive">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>F.I.Sh</th>
                                            <th>Telefon</th>
                                            <th>Guruhga qo'shish</th>
                                        </tr>
                                        </thead>
                                        <tbody id="tbody">`;
                    let countdown = 0;
                    for (var i = 0; i < references.length; i++) {
                        countdown++;
                        referencesHtml += '<tr>';
                        referencesHtml += '<td>' + countdown + '</td>';
                        referencesHtml += '<td><a href="{{ route('cashier.student') }}/'+references[i].id+'">' + references[i].name + '</a></td>';
                        referencesHtml += '<td>' + references[i].phone + '</td>';
                        referencesHtml += `<td><a href="{{ route('cashier.add_to_subject') }}/`+references[i].id+`" class="btn btn-success add-student"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus align-middle"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></a></td>`;
                        referencesHtml += '</tr>';
                    }
                    referencesHtml +=   `</tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </main>`;
                    // Display the references in the modal

                    $('#search-section').html(referencesHtml);
                    $('#main').hide();
                    $('#search-section').show();
                    // Hide the loading indicator
                    loadingIndicator.hide();
                },
                error: function() {
                    // Handle error case
                    // Hide the loading indicator
                    loadingIndicator.hide();
                }
            });
        }
        // Display the loading indicator
        loadingIndicator.show();

        // Make AJAX request to fetch search results


    });

    const fullscreenLink = document.getElementById('fullscreenLink');
    let isFullScreen = false;

    fullscreenLink.addEventListener('click', function(event) {
        event.preventDefault(); // Prevent the default behavior of the link
        toggleFullScreen();
    });

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            exitFullScreen();
        }
    });

    function toggleFullScreen() {
        if (!isFullScreen) {
            requestFullScreen();
        } else {
            exitFullScreen();
        }
    }

    function requestFullScreen() {
        const element = document.documentElement;
        if (element.requestFullscreen) {
            element.requestFullscreen();
        } else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        } else if (element.webkitRequestFullscreen) {
            element.webkitRequestFullscreen();
        } else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
        isFullScreen = true;
    }

    function exitFullScreen() {
        if (document.exitFullscreen) {
            document.exitFullscreen();
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen();
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen();
        } else if (document.msExitFullscreen) {
            document.msExitFullscreen();
        }
        isFullScreen = false;
    }
</script>
<div class="notyf" style="justify-content: flex-start; align-items: center;"></div>
<div class="notyf-announcer" aria-atomic="true" aria-live="polite" style="border: 0px; clip: rect(0px, 0px, 0px, 0px); height: 1px; margin: -1px; overflow: hidden; padding: 0px; position: absolute; width: 1px; outline: 0px;">Inconceivable!</div>
</body>

</html>
