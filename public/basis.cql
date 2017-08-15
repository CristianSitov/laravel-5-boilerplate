USING PERIODIC COMMIT
LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E55.HeritageResourceType_01.csv' AS row
  MERGE (n:HeritageResourceType {uuid: row.uuid})
    ON CREATE
    SET n = row, n.uuid = row.uuid, n.type = row.type,
    n.set_order = row.set_order, n.set = row.set, n.set_ro = row.set_ro,
    n.name_order = row.name_order, n.name = row.name, n.name_ro = row.name_ro,
    n.published = row.published, n.created_at = timestamp(), n.updated_at = timestamp()
    ON MATCH
    SET n = row, n.uuid = row.uuid, n.type = row.type,
    n.set_order = row.set_order, n.set = row.set, n.set_ro = row.set_ro,
    n.name_order = row.name_order, n.name = row.name, n.name_ro = row.name_ro,
    n.published = row.published, n.created_at = timestamp(), n.updated_at = timestamp();

USING PERIODIC COMMIT LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E55.ArchitecturalStyle_01.csv' AS row
  MERGE (n:ArchitecturalStyle {uuid: row.uuid})
    ON CREATE
    SET n = row, n.uuid = row.uuid,
    n.name_order = row.name_order, n.name = row.name, n.name_ro = row.name_ro, n.type = row.type,
    n.published = row.published, n.created_at = timestamp(), n.updated_at = timestamp()
    ON MATCH
    SET n = row, n.uuid = row.uuid,
    n.name_order = row.name_order, n.name = row.name, n.name_ro = row.name_ro, n.type = row.type,
    n.published = row.published, n.created_at = timestamp(), n.updated_at = timestamp();

USING PERIODIC COMMIT LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E48.AdministrativeSubdivision_01.csv'
AS row
  MERGE (n:AdministrativeSubdivision {uuid: row.uuid})
    ON CREATE
    SET n = row, n.uuid = row.uuid, n.name = row.name, n.created_at = timestamp(), n.updated_at = timestamp()
    ON MATCH
    SET n = row, n.uuid = row.uuid, n.name = row.name, n.created_at = timestamp(), n.updated_at = timestamp();

USING PERIODIC COMMIT LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E55.ResourceClassificationType_01.csv'
AS row
  MERGE (n:ResourceTypeClassification {uuid: row.uuid})
    ON CREATE
    SET n = row, n.uuid = row.uuid, n.type = row.type, n.created_at = timestamp(), n.updated_at = timestamp()
    ON MATCH
    SET n = row, n.uuid = row.uuid, n.type = row.type, n.created_at = timestamp(), n.updated_at = timestamp();

USING PERIODIC COMMIT LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E46.StreetName_01.csv' AS row
  MERGE (n:StreetName {uuid: row.uuid})
    ON CREATE
    SET n = row, n.uuid = row.uuid, n.ext_id = row.ext_id, n.current_name = row.current_name, n.former_name = row.
      former_name, n.type = row.type, n.document = row.document, n.district = row.district, n.guide_area = row.
      guide_area, n.year_1956 = row.year_1956, n.year_1946 = row.year_1946, n.year_1940 = row.year_1940, n.
      year_1936 = row.
      year_1936, n.created_at = timestamp(), n.updated_at = timestamp()
    ON MATCH
    SET n = row, n.uuid = row.uuid, n.ext_id = row.ext_id, n.current_name = row.current_name, n.former_name = row.
      former_name, n.type = row.type, n.document = row.document, n.district = row.district, n.guide_area = row.
      guide_area, n.year_1956 = row.year_1956, n.year_1946 = row.year_1946, n.year_1940 = row.year_1940, n.
      year_1936 = row.
      year_1936, n.created_at = timestamp(), n.updated_at = timestamp();

MATCH (s:StreetName {district:"Fabric"}), (a:AdministrativeSubdivision {name:"Fabric"}) MERGE (s)-[:IsIncorporatedIn]->(a);

USING PERIODIC COMMIT LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E57.Material_01.csv' AS row
  MERGE (n:Material {uuid: row.uuid})
    ON CREATE
    SET n = row, n.uuid = row.uuid, n.name = row.name, n.name_ro = row.name_ro, n.created_at = timestamp(), n.
      updated_at = timestamp()
    ON MATCH
    SET n = row, n.uuid = row.uuid, n.name = row.name, n.name_ro = row.name_ro, n.created_at = timestamp(), n.
      updated_at = timestamp();

USING PERIODIC COMMIT LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E55.ModificationType_01.csv' AS row
  MERGE (n:ModificationType {uuid: row.uuid})
    ON CREATE
    SET n = row, n.uuid = row.uuid, n.set = row.set, n.set_ro = row.set_ro, n.name = row.name, n.name_ro = row.
      name_ro, n.created_at = timestamp(), n.
      updated_at = timestamp()
    ON MATCH
    SET n = row, n.uuid = row.uuid, n.set = row.set, n.set_ro = row.set_ro, n.name = row.name, n.name_ro = row.
      name_ro, n.created_at = timestamp(), n.
      updated_at = timestamp();

USING PERIODIC COMMIT LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E18.ArchitecturalElement_01.csv' AS row
  MERGE (n:ArchitecturalElement {uuid: row.uuid})
    ON CREATE
    SET n = row, n.uuid = row.uuid, n.type = row.type, n.set = row.set, n.aspect = row.aspect, n.order = row.order, n.
      aspect_ro = row.aspect_ro, n.area = row.area, n.area_ro = row.area_ro, n.value = row.value, n.value_ro = row.value_ro,
      n.created_at = timestamp(), n.updated_at = timestamp()
    ON MATCH
    SET n = row, n.uuid = row.uuid, n.type = row.type, n.set = row.set, n.aspect = row.aspect, n.order = row.order, n.
      aspect_ro = row.aspect_ro, n.area = row.area, n.area_ro = row.area_ro, n.value = row.value, n.value_ro = row.value_ro,
      n.created_at = timestamp(), n.updated_at = timestamp();
