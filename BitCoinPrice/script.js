//TODO: Endpoint URL api
const URL = "https://api.coindesk.com/v1/bpi/currentprice.json";
async function fetchData() {
  try {
    const response = await fetch(URL);
    //TODO: Cek koneksi ke server backend
    if (!response.ok) {
      throw new Error("network response not ok" + response.statusText);
    }
    //TODO: Hasil pengambilan data JSON
    const data = await response.json();
    console.log(data);

    //TODO: Ekstrak data yang diinginkan
    const { time, bpi } = data;
    const timeUpdated = time.updated;
    const usdPrice = bpi.USD.rate;
    const gbpPrice = bpi.GBP.rate;
    const euroPrice = bpi.EUR.rate;

    const container = document.getElementById("data-container");
    container.innerHTML = `
    <p>Last Updated : ${timeUpdated}</p>
    
    <div class="col-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Price in USD &#40;&dollar;&#41;</h5>
          <h6 class="card-subtitle mb-2 text-body-secondary">${usdPrice}</h6>
        </div>
      </div>
    </div>

    <div class="col-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Price in Pounds &#40;&pound;&#41;</h5>
          <h6 class="card-subtitle mb-2 text-body-secondary">${gbpPrice}</h6>
        </div>
      </div>
    </div>

    <div class="col-4">
      <div class="card mb-3">
        <div class="card-body">
          <h5 class="card-title">Price in Euro &#40;&euro;&#41;</h5>
          <h6 class="card-subtitle mb-2 text-body-secondary">${euroPrice}</h6>
        </div>
      </div>
    </div>
    

    `;
  } catch (error) {}
}

fetchData(); //TODO: Memanggil Function
