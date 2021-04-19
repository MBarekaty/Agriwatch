import cgi
# cgitb module for debugging:
import cgitb
cgitb.enable()
import json
import psycopg2
from psycopg2.extras import RealDictCursor
 
#print ("Content-type: text/html; charset=utf-8")
#print ()
 
params = cgi.FieldStorage()
country_name = params.getvalue("country_name")
 
if country_name.lower() in ("netherlands","germany","belgium"):
    
  pg = psycopg2.connect("dbname='exercises' host='gisedu.itc.utwente.nl' port='5432' \
                        user='exercises' password='exercises'") 
                           
  records_query = pg.cursor(cursor_factory=RealDictCursor)
  records_query.execute("""
      SELECT 'Feature' as type, 
             gid as id, 
             row_to_json((SELECT list FROM (SELECT cntry_name) AS list )) as properties, 
             ST_AsGeoJSON(ST_Transform(the_geom,4326),6) as geometry 
      FROM world.country 
      where cntry_name='%s'; 
  """   % (country_name))
                           
  result = '{"type":"FeatureCollection", "features":' + str(records_query.fetchall()) + '}'  
  result = result.replace( "'{" , "{" ).replace( "}'" , "}" )
  
  print ("Content-type: application/json; charset=utf-8")
  print ()
  print ( result.replace( "'" , '"' ) )
 
else:
 
  print ("Content-type: text/html; charset=utf-8")
  print ()
  print ("The URI '.../services/provinces.py?countryname=%s' produced no results" % (country_name))