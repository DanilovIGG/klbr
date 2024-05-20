document.addEventListener("DOMContentLoaded", () => {
  document.getElementById('status').addEventListener('change', function() {
    var status = this.value;
    var orders = document.querySelectorAll('.order');
    
    orders.forEach(function(order) {
        var isPaid = order.getAttribute('data-paid') === 'Y';
        if (status === 'all' || 
            (status === 'paid' && isPaid) || 
            (status === 'unpaid' && !isPaid)) {
            order.style.display = 'block';
        } else {
            order.style.display = 'none';
        }
    });
});
});
