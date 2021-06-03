<script>
    Spinner();
    fetchCategory('ships');
    fetchCategory('vehicles');
    fetchCategory('goods');

    function deleteItem(category, id) {
        Spinner.show();
        const request = new XMLHttpRequest();
        request.open('POST', `/paperopoli_terminal/${category}/delete`);
        request.send(JSON.stringify({
            id
        }));
        request.responseType = 'json';
        request.onload = function() {
            Spinner.hide();
            if (request.status === 200) {
                document.getElementById(`${category}-${id}`).remove();
            } else {
                //TODO: Show notification
            }
        }
    }

    function fetchCategory(category) {
        Spinner.show();
        try {
            document.getElementById(`tbody-${category}`).remove();
        } catch (_) {}
        fetch(
                `/paperopoli_terminal/${category}/index`, {
                    headers: {
                        'Content-Type': 'application/json',
                    }
                },
            )
            .then((response) => {
                Spinner.hide();
                return response.json();
            })
            .then((data) => {
                try {
                    document.getElementById(`tbody-${category}`).remove();
                } catch (_) {}
                const table = document.getElementById(`table-${category}`);
                const tbody = document.createElement(`tbody`);
                tbody.id = `tbody-${category}`;
                Object.keys(data).forEach((element) => {
                    const id = category === 'vehicles' ? data[element].targa : data[element].ID;
                    tbody.innerHTML +=
                        `<tr id=${category}-${id}>
                            <td>${id}</td>
                            <td>${data[element].stato}</td>
                            <td class='text-center'>
                                <a class='btn btn-info btn-xs' href='/paperopoli_terminal/${category}/edit/${id}'>
                                    <span class='glyphicon glyphicon-edit'>Edit</span>
                                </a>
                                <button onclick="deleteItem('${category}', '${id}')" class='btn btn-danger btn-xs'>
                                    <span class='glyphicon glyphicon-remove'>Del</span>
                                </button>
                            </td>
                        </tr>
                        `
                });
                table.appendChild(tbody);
            })
            .catch((err) => {
                Spinner.hide();
                console.log('error: ' + err);
            });
    }
</script>

<section id="new-action-section">
    <div class="row col-md-12 centered">
        <table id="table-ships" class="table table-striped custab">
            <thead>
                <a href="/paperopoli_terminal/ships/create/" class="btn btn-primary btn-xs pull-right"><b>+</b> Nuova nave</a>
                <button onclick="fetchCategory('ships')" style="background-color: transparent; border-style: none; margin-left: 20px;">
                    <i class="fa fa-refresh"></i>
                </button>
                <tr>
                    <th>ID</th>
                    <th>Stato</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <br>
    <div class="row col-md-12 centered">
        <table id="table-goods" class="table table-striped custab">
            <thead>
                <a href="/paperopoli_terminal/goods/create/" class="btn btn-primary btn-xs pull-right"><b>+</b> Nuova merce</a>
                <button onclick="fetchCategory('goods')" style="background-color: transparent; border-style: none; margin-left: 20px;">
                    <i class="fa fa-refresh"></i>
                </button>
                <tr>
                    <th>ID</th>
                    <th>Stato</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
    <br>
    <div class="row col-md-12 centered">
        <table id="table-vehicles" class="table table-striped custab">
            <thead>
                <a href="/paperopoli_terminal/vehicles/create/" class="btn btn-primary btn-xs pull-right"><b>+</b> Nuovo veicolo</a>
                <button onclick="fetchCategory('vehicles')" style="background-color: transparent; border-style: none; margin-left: 20px;">
                    <i class="fa fa-refresh"></i>
                </button>
                <tr>
                    <th>Targa</th>
                    <th>Stato</th>
                    <th class="text-center">Action</th>
                </tr>
            </thead>
        </table>
    </div>
</section>