// Handles navigation buttons for mobile view
// Desktop view doesn't use any JS

{
  const nav = document.getElementById( 'header-navbar' );
  const menu = nav.getElementsByTagName( 'ul' )[0];
  const menuBtn = document.querySelector( '#mobile_navbar-toggle button' );
  const submenuParents = nav.querySelectorAll( 'li.menu-item-has-children' );
  var menu_buttons = []; // Array of {'btn': btn, 'menu': menu}

  if ( !menu.classList.contains( 'nav-menu' ) ) {
    menu.classList.add( 'nav-menu' );
  }

  menu_buttons.push( {'btn': menuBtn, 'menu': menu} );
  submenuParents.forEach( (li) => {
    const ul = li.getElementsByTagName( 'ul' )[0];
    const btn = li.getElementsByClassName( 'submenu-toggle' )[0];
    menu_buttons.push( {'btn': btn, 'menu': ul} );
  });

  // Helper functions

  // Expand menu
  function addClickButton(parent, btn) {
    btn.addEventListener( 'click', function() {
      parent.classList.toggle( 'toggled' );
      btn.classList.toggle( 'toggled' );

      btn.setAttribute(
        'aria-expanded', btn.getAttribute('aria-expanded') === 'true'
          ? 'false'
          : 'true'
      );
    });
  }

  // Collapse menu if you click outside of it and the button
  function collapseOutside(menu, btn, t) {
    if ( !menu.contains(t) && !btn.contains(t) ) {
      menu.classList.remove( 'toggled' );
      btn.classList.remove( 'toggled' );
      btn.setAttribute( 'aria-expanded', 'false' );
    }
  }

  menu_buttons.forEach( (d) => {
    addClickButton(d['menu'], d['btn']);
  })

  document.addEventListener( 'click', function(event) {
    menu_buttons.forEach( (d) => {
      collapseOutside(d['menu'], d['btn'], event.target);
    })
  });


}
