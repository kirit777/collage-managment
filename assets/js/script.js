function toggleSidebar() {
  document.getElementById('sidebar')?.classList.toggle('open');
}

function togglePassword() {
  const input = document.getElementById('password');
  if (!input) return;
  input.type = input.type === 'password' ? 'text' : 'password';
}

function toggleTheme() {
  const html = document.documentElement;
  html.setAttribute('data-theme', html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
}

function demoDelete() {
  alert('Delete action simulated in demo mode.');
}

function initCharts() {
  const labels = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  const admission = document.getElementById('admissionChart');
  const fee = document.getElementById('feeChart');
  const attendance = document.getElementById('attendanceChart');
  if (admission && window.Chart) {
    new Chart(admission, { type: 'bar', data: { labels, datasets: [{ label: 'Admissions', data: JSON.parse(admission.dataset.values), borderRadius: 8, backgroundColor: '#2b73ff' }] } });
  }
  if (fee && window.Chart) {
    new Chart(fee, { type: 'line', data: { labels, datasets: [{ label: 'Fees (Lakhs)', data: JSON.parse(fee.dataset.values), tension: .35, borderColor: '#16a34a', fill: true, backgroundColor: 'rgba(22,163,74,.18)' }] } });
  }
  if (attendance && window.Chart) {
    new Chart(attendance, { type: 'doughnut', data: { labels: ['Present','Absent','Leave'], datasets: [{ data: [88, 8, 4], backgroundColor: ['#2563eb', '#ef4444', '#f59e0b'] }] } });
  }
}

window.addEventListener('load', () => {
  document.getElementById('loader')?.classList.add('hide');
  initCharts();

  document.querySelectorAll('input[placeholder*="Live search"]').forEach((searchInput) => {
    searchInput.addEventListener('input', () => {
      const filter = searchInput.value.toLowerCase();
      document.querySelectorAll('tbody tr').forEach((row) => {
        row.style.display = row.innerText.toLowerCase().includes(filter) ? '' : 'none';
      });
    });
  });
});
