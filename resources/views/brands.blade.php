<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Brands</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        body {
            font-family: Arial;
            margin: 20px;
        }

        .brand-list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .brand {
            border: 1px solid #ddd;
            padding: 10px;
            border-radius: 8px;
            width: 150px;
            text-align: center;
        }

        img {
            width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>

<h1>Top Brands</h1>
<div class="brand-list" id="brands"></div>

<script>
    fetch('/api/brands')
        .then(response => response.json())
        .then(brands => {
            const list = document.getElementById('brands');
            brands.forEach(brand => {
                const div = document.createElement('div');
                div.className = 'brand';
                div.innerHTML = `
                <img src="${brand.brand_image || 'https://via.placeholder.com/150'}" alt="${brand.brand_name}">
                <h4>${brand.brand_name}</h4>
                <p>Rating: ${brand.rating}/5</p>
            `;
                list.appendChild(div);
            });
        });
</script>

</body>
</html>
