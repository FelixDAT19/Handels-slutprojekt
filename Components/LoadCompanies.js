import React from "react";
import {useRouter} from 'next/router'
import Link from "next/link";

function LoadCompanies({ id, name, companyInfo, externalUrl, logoUrl, offers, competitions }) {

  const router =  useRouter();

  return (
    <div>
      <img src={logoUrl} alt={logoUrl} />
      <h1>{name}</h1>
      <p>
        {companyInfo}
        <br />
        <Link href={externalUrl}>{externalUrl}</Link>
      </p>
      <h3>Erbjudanden</h3>
      {offers.map(({offer, price}, s) => (
        <div key={s}>
            <p>{offer} {price}</p>
        </div>
      ))}
      {competitions.map(({formUrl}, s) => (
        <div key={s}>
            <Link herf={formUrl} className="competitionLink">Tävling</Link>
        </div>
      ))}
    </div>
  );
}

export default LoadCompanies;
