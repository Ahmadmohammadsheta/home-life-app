<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @include('layouts.head')
	</head>

	<body>

        <div class="wrapper">
            <aside id="sidebar">
                @include('layouts.main-sidebar')
            </aside>

            <!-- my main -->
            <div class="main">
                <nav class="navbar navbar-expand px-4 py3">
                    @include('layouts.navbar')
                </nav>

                <main class="content px-3 py-4">
                    <div class="container-fluid">
                        <!-- breadcrumb -->
                        <div class="breadcrumb-header justify-content-between">
                            <div class="my-auto">
                                <div class="d-flex">
                                    <h4 class="content-title mb-0 my-auto">{{ isset($tableName) ? ucfirst($tableName) : 'Main Page'}}</h4>
                                    <span class="text-muted mt-1 tx-13 mr-2 mb-0">@yield('title')</span>
                                </div>
                            </div>
                        </div>
                        <!-- breadcrumb -->
                        <div class="mb-3">
                            <div class="mb3">
                                @if (session()->has('session'))
                                <div class="alert alert-{{ session('session') }} text-center text-bold" style="font-weight: bolder; font-size:xx-large">{{ session('message') }}</div>
                                @endif
                            </div>
                            @yield('content')
                        </div>
                    </div>
                </main>

                <footer class="footer">
                    @include('layouts.footer')
                </footer>
            </div>
            <!-- my main closed -->
        </div>


        @include('layouts.footer-scripts')
	</body>
</html>
