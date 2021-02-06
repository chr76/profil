import * as THREE from 'three';

document.addEventListener( 'DOMContentLoaded', function() {

    const canvas = document.querySelector( '#splash canvas' );
    const header = document.querySelector( '#splash' );
    const HEIGHT = header.offsetHeight;
    const WIDTH = header.offsetWidth;
    const ratio = WIDTH / HEIGHT;
    const fov = 75;
    // const aspect = 2;
    const near = 0.1;
    const far = 5;
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera( fov, ratio, near, far );
    // const camera = new THREE.OrthographicCamera( 
    //     10 * ratio / -4,
    //     10 * ratio / 4,
    //     10 / 4,
    //     10 / -4,
    //     0.1,
    //     50
    // );
    camera.position.z = 2;
    const renderer = new THREE.WebGLRenderer( { canvas, alpha: true, antialias: true } );
    
    const geometry = new THREE.BoxGeometry();
    const material = new THREE.MeshBasicMaterial( { color: 0x00ff00 } );
    const cube = new THREE.Mesh( geometry, material );
    scene.add( cube );
    
    function animate() {

        requestAnimationFrame( animate );
        cube.rotation.x += 0.01;
        cube.rotation.y += 0.01;
        renderer.render( scene, camera );

    }
    animate();

} );