import React from "react";
import {useRouter} from 'next/router'

function LoadCompanies({ id, name, companyInfo, externalUrl, logoUrl, offers, competitions }) {

  const router =  useRouter();

  return (
    <div>
      <img src={logoUrl} alt={logoUrl} />
      <h1>{name}</h1>
      <p>
        {companyInfo}
        <br />
        <a href={externalUrl}>{externalUrl}</a>
      </p>
      <h3>Erbjudanden</h3>
      {offers.map(({offer, price}, s) => (
        <div key={s}>
            <p>{offer} {price}</p>
        </div>
      ))}
      {competitions.map(({formUrl}, s) => (
        <div key={s}>
            <a passHerf={formUrl}>Tävling</a>
        </div>
      ))}
    </div>
  );
}

export default LoadCompanies;
