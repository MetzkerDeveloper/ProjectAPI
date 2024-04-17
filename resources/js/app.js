import './bootstrap';


var urlAPI = "http://127.0.0.1:8000/api/users/";


async function getUser() {
  try {
      const response = await axios.get(urlAPI);
      const data = response.data;
      return data;
  } catch (error) {
      console.error(error);
  }
}

const showUsers = async () => {
  const data = await getUser();
  var tbody = document.querySelector('tbody');
  if (data.length > 1) {
      data.forEach(user => {
          var tr = document.createElement('tr');
          tr.innerHTML = `
        <td>${user.id}</td>
        <td>${user.name}</td>
        <td>${user.email}</td>
    `;
          tbody.appendChild(tr);
      });
  } else {
      showUser();
  }

}
showUsers();

const showUser = async () => {
  const data = await getUser();
  var tbody = document.querySelector('tbody');
  if (data) {
      var tr = document.createElement('tr');

      tr.innerHTML = `
  <td>${data.id}</td>
  <td>${data.name}</td>
  <td>${data.email}</td>
`;

      tbody.appendChild(tr);
  }
}