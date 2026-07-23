form.addEventListener('submit', function (e) {
  e.preventDefault();

  const data = {
    regNumber: document.getElementById('regNumber').value.trim(),
    fullName: document.getElementById('fullName').value.trim(),
    course: document.getElementById('course').value,
    gender: (form.querySelector('input[name="gender"]:checked') || {}).value || '',
    email: document.getElementById('email').value.trim()
  };

  if (!validate(data)) return;

  // Send data to PHP backend
  fetch('add_students.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
    body: new URLSearchParams(data)
  })
    .then(response => response.json())
    .then(result => {
      if (result.success) {
        serialStamp.textContent = `FORM REF: ${result.reference}`;

        receipt.innerHTML = `
        <div><span>Reference</span><span>${result.reference}</span></div>
        <div><span>Reg. Number</span><span>${result.regNumber}</span></div>
        <div><span>Full Name</span><span>${result.fullName}</span></div>
        <div><span>Course</span><span>${result.course}</span></div>
        <div><span>Gender</span><span>${result.gender}</span></div>
        <div><span>Email</span><span>${result.email}</span></div>
      `;

        formView.style.display = 'none';
        successView.classList.add('show');
      } else {
        alert(result.message); // shows the PHP error if something went wrong
      }
    })
    .catch(err => {
      alert('Something went wrong submitting the form. Please try again.');
      console.error(err);
    });
});