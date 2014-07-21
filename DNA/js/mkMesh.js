function createMesh(geom) {
        var meshMaterial = new THREE.MeshPhongMaterial({specular: 0xffffff, color: 0x0f00ff, shininess: 100, metal: true, transparent : true});
        var plane = THREE.SceneUtils.createMultiMaterialObject(geom, [meshMaterial]);
        var plane = new THREE.Mesh(geom,meshMaterial);

        return plane;
}