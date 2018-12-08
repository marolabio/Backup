import React from 'react';
// import { Link } from 'gatsby';

import Layout from '../components/layout'
import Image from '../components/image'

const IndexPage = () => (
  <Layout>
    <h1>Welcome to my website</h1>
    <p>This iis a sample site for the gatsby crash course</p>
    <div style={{ maxWidth: '300px', marginBottom: '1.45rem' }}>
      <Image />
    </div>

  </Layout>
)

export default IndexPage
