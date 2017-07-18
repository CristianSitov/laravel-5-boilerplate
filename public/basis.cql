LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E55.HeritageResourceType_01.csv' AS row
CREATE (n:HeritageResourceType)
SET n = row, n.uuid = row.uuid, n.name = row.name, n.name_ro = row.name_ro, n.set = row.set, n.
  set_ro = row.set_ro, n.published = row.published, n.created_at = timestamp(), n.updated_at = timestamp();

LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E55.ArchitecturalStyle_01.csv' AS row
CREATE (n:ArchitecturalStyle)
SET n = row, n.uuid = row.uuid, n.name = row.name, n.name_ro = row.name_ro, n.published = row.published, n.note = row.
  note, n.created_at = timestamp(), n.updated_at = timestamp();

LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E48.AdministrativeSubdivision_01.csv' AS row
CREATE (n:AdministrativeSubdivision)
SET n = row, n.uuid = row.uuid, n.name = row.name, n.created_at = timestamp(), n.updated_at = timestamp();

LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E55.ResourceClassificationType_01.csv' AS row
CREATE (n:ResourceTypeClassification)
SET n = row, n.uuid = row.uuid, n.type = row.type, n.created_at = timestamp(), n.updated_at = timestamp();

LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E46.StreetName_01.csv' AS row
CREATE (n:StreetName)
SET n = row, n.uuid = row.uuid, n.ext_id = row.ext_id, n.current_name = row.current_name, n.former_name = row.
  former_name, n.type = row.type, n.document = row.document, n.district = row.district, n.guide_area = row.
  guide_area, n.year_1956 = row.year_1956, n.year_1946 = row.year_1946, n.year_1940 = row.year_1940, n.year_1936 = row.
  year_1936, n.created_at = timestamp(), n.updated_at = timestamp();

LOAD CSV WITH HEADERS FROM 'http://heritageoftimisoara.dev/E18.PlotPlan_01.csv' AS row
CREATE (n:PlotPlan)
SET n = row, n.uuid = row.uuid, n.name = row.name, n.name_ro = row.name_ro, n.created_at = timestamp(), n.updated_at = timestamp();
