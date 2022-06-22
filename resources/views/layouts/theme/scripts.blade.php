<script src="{{ asset('assets/js/core/popper.min.js')}}" ></script>
<script src="{{ asset('assets/js/core/bootstrap.min.js')}}" ></script>
<script src="{{ asset('assets/js/plugins/perfect-scrollbar.min.js')}}" ></script>
<script src="{{ asset('assets/js/plugins/smooth-scrollbar.min.js')}}" ></script>

<script>
var win = navigator.platform.indexOf('Win') > -1;
if (win && document.querySelector('#sidenav-scrollbar')) {
  var options = {
    damping: '0.5'
  }
  Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
}
</script>

<!-- Github buttons -->
<script async defer src="https://buttons.github.io/buttons.js"></script>

<!-- Control Center for Soft Dashboard: parallax effects, scripts for the example pages etc -->
<script src="{{ asset('assets/js/argon-dashboard.min.js?v=2.0.3')}}"></script>

<script src="{{ asset('assets/js/libs/jquery-3.1.1.min.js') }}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="{{ asset('plugins/notification/snackbar.min.js') }}"></script>


<script>
  function noty(msg, option = 1) {
      Snackbar.show({
          text: msg.toUpperCase(),
          actionText: 'Cerrar',
          actionTextColor: '#FFFFFF',
          backgroungColor: option == 1 ? '#FF7900' : '#e7515a',
          pos: 'top-right'
      });
  }
</script>


@livewireScripts