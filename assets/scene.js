import * as THREE from 'three';

function main() {
    
    const header = document.querySelector( '#splash' );
    const WIDTH = header.clientWidth;
    const HEIGHT = header.clientHeight;

    const canvas = document.querySelector( '#splash canvas' );
    const renderer = new THREE.WebGLRenderer( { canvas, alpha: true, antialias: true } );

    const fov = 40;
    const aspect = WIDTH / HEIGHT;
    const near = 0.1;
    const far = 1000;
    const camera = new THREE.PerspectiveCamera( fov, aspect, near, far );
    camera.position.z = 12;

    const scene = new THREE.Scene();

    const color = 0xFFFFFF;
    const intensity = 1;
    const light = new THREE.DirectionalLight( color, intensity );
    light.position.set( -1, 2, 4 );
    scene.add( light );

    const boxWidth = 1;
    const boxHeight = 1;
    const boxDepth = 1;
    const geometry = new THREE.BoxGeometry( boxWidth, boxHeight, boxDepth );
    // const material = new THREE.MeshPhongMaterial( { color: 0x00ff00 } );
    // const cube = new THREE.Mesh( geometry, material );
    // scene.add( cube );

    function makeInstance( geometry, color, x ) {
        
        const material = new THREE.MeshPhongMaterial( { color } );

        const cube = new THREE.Mesh( geometry, material );
        scene.add( cube );

        cube.position.x = x;

        return cube;

    }

    const cubes = [
        makeInstance( geometry, 0x44aa88, 0 ),
        makeInstance( geometry, 0x8844aa, -2 ),
        makeInstance( geometry, 0xaa8844, 2 ),
    ]

    function resizeRendererToDisplaySize( renderer ) {
        
        const canvas = renderer.domElement;
        const pixelRatio = window.devicePixelRatio;
        const width = canvas.clientWidth * pixelRatio | 0;
        const height = canvas.clientHeight * pixelRatio | 0;
        const needResize = canvas.width !== width || canvas.height !== height;
        if ( needResize ) {
            
            renderer.setSize( width, height, false );

        }
        return needResize;

    }
    
    function render(time) {

        time *= 0.001;

        // cube.rotation.x += 0.01;
        // cube.rotation.y += 0.01;

        if ( resizeRendererToDisplaySize( renderer ) ) {

            const canvas = renderer.domElement;
            camera.aspect = canvas.clientWidth / canvas.clientHeight;
            camera.updateProjectionMatrix();

        }

        cubes.forEach( ( cube, ndx ) => {

            const speed = 1 + ndx * 0.1;
            const rot = time * speed;
            cube.rotation.x = rot;
            cube.rotation.y = rot;

        } );

        renderer.render( scene, camera );

        requestAnimationFrame( render );

    }
    requestAnimationFrame( render );

}

document.addEventListener( 'DOMContentLoaded', main );