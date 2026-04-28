const root = document.documentElement;
function toggleTheme(){ const next = root.dataset.theme === 'dark' ? 'light' : 'dark'; root.dataset.theme = next; localStorage.setItem('theme', next);} 
function toggleSidebar(){ document.getElementById('sidebar')?.classList.toggle('open'); }
(function initTheme(){ root.dataset.theme = localStorage.getItem('theme') || 'light';})();
setInterval(()=>{const el=document.getElementById('clock'); if(el){el.textContent=new Date().toLocaleString();}},1000);

document.addEventListener('DOMContentLoaded',()=>{
  const search=document.getElementById('globalSearch');
  if(search){search.addEventListener('input',()=>{
    const q=search.value.toLowerCase();
    document.querySelectorAll('[data-search]').forEach(r=>r.style.display=r.dataset.search.toLowerCase().includes(q)?'':'none');
  });}

  const admissions = document.getElementById('admissionsChart');
  if(admissions){ new Chart(admissions,{type:'line',data:{labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],datasets:[{label:'Admissions',data:JSON.parse(admissions.dataset.values),borderColor:'#3d6aff',backgroundColor:'rgba(61,106,255,.15)',fill:true,tension:.35}]},options:{plugins:{legend:{display:false}}}});} 
  const revenue = document.getElementById('revenueChart');
  if(revenue){ new Chart(revenue,{type:'bar',data:{labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],datasets:[{label:'Revenue',data:JSON.parse(revenue.dataset.values),backgroundColor:'#10b981'}]}});} 
  const course = document.getElementById('courseChart');
  if(course){ new Chart(course,{type:'doughnut',data:{labels:['BCA','BBA','MBA','BCom','MCA'],datasets:[{data:[110,96,72,85,64]}]}});} 
});
