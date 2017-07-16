LOAD CSV WITH HEADERS FROM "http://heritageoftimisoara.dev/E55.HeritageResourceType_01.csv" AS row CREATE (n:HeritageResourceType) SET n = row, n.uuid = row.uuid, n.type = row.type, n.type_ro = row.type_ro, n.type_set = row.type_set, n.type_set_ro = row.type_set_ro, n.published_at = row.published, n.created_at = timestamp(), n.updated_at = timestamp();

LOAD CSV WITH HEADERS FROM "http://heritageoftimisoara.dev/E55.ArchitecturalStyle_01.csv" AS row CREATE (n:ArchitecturalStyle)
SET n = row, n.uuid = row.uuid, n.name = row.name, n.lang_ro = row.lang_ro, n.publised = row.published, n.note = row.note, n.created = row.created, n.updated = row.updated;

LOAD CSV WITH HEADERS FROM "http://heritageoftimisoara.dev/E48.AdministrativeSubdivision_01.csv" AS row CREATE (n:AdministrativeSubdivision) SET n = row, n.uuid = row.uuid, n.name = row.name, n.created = row.created, n.updated = row.updated;

LOAD CSV WITH HEADERS FROM "http://heritageoftimisoara.dev/E55.ResourceClassificationType_01.csv" AS row CREATE (n:ResourceTypeClassification) SET n = row, n.uuid = row.uuid, n.type = row.type, n.created = row.created, n.updated = row.updated;

LOAD CSV WITH HEADERS FROM "http://heritageoftimisoara.dev/E46.StreetName_01.csv" AS row CREATE (n:StreetName) SET n = row, n.uuid = row.uuid, n.ext_id = row.ext_id, n.current_name = row.current_name, n.former_name = row.former_name, n.type = row.type, n.document = row.document, n.district = row.district, n.guide_area = row.guide_area, n.year_1956 = row.year_1956, n.year_1946 = row.year_1946, n.year_1940 = row.year_1940, n.year_1936 = row.year_1936;
