
  const links = document.querySelectorAll("nav li a");
  const currentPath = window.location.pathname;

  links.forEach(link => {
    if (link.getAttribute("href") === currentPath.split("/").pop()) {
      link.classList.add("active");
    }
  });



