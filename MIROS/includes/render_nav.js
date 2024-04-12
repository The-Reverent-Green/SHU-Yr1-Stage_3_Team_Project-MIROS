function addStylesheet(href, integrity, crossorigin) {
    // Adds a stylesheet link to the head
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = href;
    if (integrity) {
        link.integrity = integrity; //Protects from Subresource Integrity (SRI) attacks
        link.crossOrigin = crossorigin; //Cross-Origin Resource Sharing (CORS)
    }
    document.head.appendChild(link);
}

function getUlClasses(data) {
    let ulClassArray = ['nav', 'nav-pills', 'nav-fill'];
    if (data.role === 'admin') {
        ulClassArray.push('admin-mode', 'flex');
    }
    return ulClassArray;
}
function appendLink(ul, key, value) {
    const li = document.createElement('li');
    li.textContent = key;
    li.classList.add('nav-item');
    
    if (typeof value === 'string') {
        li.addEventListener('click', () => {
            window.location.href = value;
        });
    } else if (typeof value === 'object') {
        li.classList.add('dropdown');
        
        // Create dropdown toggle link
        const a = document.createElement('a');
        a.classList.add('nav-link', 'dropdown-toggle');
        a.href = "#";
        a.setAttribute('role', 'button');
        a.setAttribute('data-toggle', 'dropdown');
        a.setAttribute('aria-haspopup', 'true');
        a.setAttribute('aria-expanded', 'false');
        a.textContent = key;
        li.textContent = ''; // Clear the text content as it's now in the toggle
        li.appendChild(a);
        
        // Create the div to encapsulate sublinks
        const div = document.createElement('div');
        div.classList.add('dropdown-menu');
        
        Object.entries(value).forEach(([subKey, subValue]) => {
            const subLi = document.createElement('a'); // Use 'a' for sub-links for better accessibility and styling
            subLi.classList.add('dropdown-item');
            subLi.textContent = subKey;
            subLi.href = subValue;
            div.appendChild(subLi);
        });
        
        li.appendChild(div);
    }

    ul.appendChild(li);
}
  
async function makeNavBar() {
    try {
        const response = await fetch('../includes/new_nav.php?action=getNav');
        if (!response.ok) {
            throw new Error('Network response was not ok: ' + response.statusText);
        }
        const data = await response.json();
        
        const ul = document.createElement('ul');
        ul.classList.add(...getUlClasses(data));
        Object.entries(data.links).forEach(([key, value]) => {
            appendLink(ul, key, value);
        });
        
        // Append the ul to the navbar
        document.getElementById('navBar').appendChild(ul);
    } catch (error) {
        console.error('There was a problem with the fetch operation: ', error);
    }
}
document.addEventListener('DOMContentLoaded', function() {
    addStylesheet('../css/nav_bar.css');
    addStylesheet('https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css', 'sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm', 'anonymous');
    addStylesheet('../css/bootstrap.css');
    makeNavBar();
});