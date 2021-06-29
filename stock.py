import pymysql
import requests
from bs4 import BeautifulSoup

#크롤링 할 주소
URL = 'https://finance.naver.com/sise/lastsearch2.nhn';
#크롤링
response = requests.get(URL)
#크로링한 데이터를 text형식으로 변환
html = response.text

#BeautifulSoup을이용해 html파싱
soup = BeautifulSoup(html, 'html.parser')

#table태그의 type_5클래스 선택
result = soup.find('table', 'type_5')
#tr태그 전체를 선택
trs = result.find_all('tr')

#빈배열
data = list()

#trs배열을 순회 값=tr
for tr in trs :
    #td태그를 전부 선택
    tds = tr.find_all('td')
    #tds의 배열요소가 12개가 아닐경우 건너뜀
    if len(tds) != 12 :
        continue
    i=0
    td_data = list()
    #tds배열을 순회 값=td
    for td in tds :
        text = td.text.strip()
        td_data.append(text)
        i+=1
        if i == 12 :
            data.append(td_data)
        
dbURL = '호스트'
dbPort=포트번호
dbUser='닉네임입력'
dbPass='db비밀번호입력'

conn = pymysql.connect(
    host=dbURL, port=dbPort, user=dbUser, passwd=dbPass, db='db이름',
    charset='utf8', use_unicode=True
)

cur = conn.cursor()
cur.execute('TRUNCATE stock')
conn.commit()

insert_stock = "INSERT INTO stock VALUES (%s, %s, %s, %s,%s, %s, %s, %s,%s, %s, %s, %s)"

for d in data :
    cur = conn.cursor()
    cur.execute(insert_stock, (d[0], d[1], d[2], d[3], d[4], d[5], d[6], d[7], d[8], d[9], d[10], d[11]))
    conn.commit()